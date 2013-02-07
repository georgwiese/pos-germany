<?php
require_once("PHPExcel/IOFactory.php");
require_once("Table.php");
require_once("TableRow.php");
PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, array(' memoryCacheSize ' => '20MB'));
PHPExcel_Settings::setLocale("sk-sk");

/**
 * Created by JetBrains PhpStorm.
 * User: martin.maliska
 * Date: 10.2.2012
 * Time: 22:16
 * To change this template use File | Settings | File Templates.
 * @property mixed year
 */
class ExcelParser {
	private $currentTable;
	private $currentRowIndex;
	private $currentCommand;
	private $currentCommandExpectsData;
	private $currentRowType;
	private $useFirstLanguage;
	private $currentRowPercentValue;
	private $languageRowSkipped;
	private $previousRowType;
	private $languageColumnSkipped;
	private $currentTableCellCount = "X";
	private $lastFoldingRowParentId;
	private $currentAnnualChangeValue;
	private $tableDao;
	private $currentRowSpan;
	private $tableCount;

	const DATA_ROW_TYPE = 1;
	const STARTING_CONTROL_ROW_TYPE = 2;
	const CELL_CONTROL_ROW_TYPE = 3;
	const UKNOWN_ROW_TYPE = 4;
	const ENDING_CONTROL_ROW_TYPE = 5;

	const TABLE_START_COMMAND = "TableStart";
	const TABLE_END_COMMAND = "TableEnd";
	const TABLE_NAME_COMMAND = "TableName";
	const MIRROR_COMMAND = "Mirror";

	const ACTIVE_COLUMN_FLAG = "C";
	const FOLDING_COLUMN_FLAG = "Folding";
	const GRAPH_X1_AXIS_FLAG = "G1";
	const GRAPH_X2_AXIS_FLAG = "G2";
	const ANNUAL_CHANGE_COMPUTATION_COLUMN_FLAG = "AV";
	const ANNUAL_CHANGE_FLAG = "AC";
	const ROUNDING_FLAG = "R";

	private $currentSheetRowSpans;
	private $currentSheetColSpans;
	private $currentSheetMergedRows;
	private $message;

	public function parseExcel($fileName, $path) {
		$started = time();
		$this->year = $this->extractYearFromFileName($fileName);
		$excelFile = PHPExcel_IOFactory::load($path);
		set_time_limit(100);
		$this->message .= "Processing file: " . $fileName. " detected year: ". ($this->year > 0 ? $this->year : "annual");
		$this->message .= "\n\t". "Loaded in: " . (time() - $started) . " seconds.";
		$this->message .= "\n\tFound ".sizeof($excelFile->getAllSheets())." worksheets";
		foreach ($excelFile->getAllSheets() as $worksheet) {
			$this->message .= "\n\tProcessing worksheet: " . $worksheet->getTitle();
			$this->parseWorksheet($worksheet);
		}

		$this->message .= "\n File processed in: " . (time() - $started) . " seconds.";
		return $this->message;
	}

	private function extractYearFromFileName($fileName) {
		$extensionDelimiterIndex = strrpos($fileName, '.');
		if ($extensionDelimiterIndex >= 4) {
			$yearCandidate = substr($fileName, $extensionDelimiterIndex - 4, 4);
			return is_numeric($yearCandidate) ? $yearCandidate : 0;
		}
		return 0;
	}

	private function parseWorksheet(PHPExcel_Worksheet $worksheet) {
		$this->tableCount = 0;
		$this->languageRowSkipped = false;
		$this->previousRowType = null;
		$this->lastFoldingRowParentId = 0;
		$this->readSpanConfiguration($worksheet);
		foreach ($worksheet->getRowIterator() as $row) {
			$this->parseRow($row, $worksheet);
		}
		$this->message .= "\n\t\tTables: ". $this->tableCount;
	}

	private function parseRow(PHPExcel_Worksheet_Row $row, PHPExcel_Worksheet $worksheet) {
		$this->languageColumnSkipped = false;
		$this->currentRowPercentValue = null;
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		//$skipRow = (!isset($this->currentSheetMergedRows[$row->getRowIndex()])) && $this->skipRowSpecificToLanguage();
		$skipRow = $this->skipRowSpecificToLanguage();

        if ($skipRow) {
//            echo "\n\t\t\tSkipping language row: ".$row->getRowIndex(). "<br/>";

        }

        for ($cellIndex = "A"; $cellIndex <= $this->currentTableCellCount; $cellIndex++) {
			$this->processCell($worksheet->getCell($cellIndex . $row->getRowIndex()), $skipRow);
		}


		//$this->languageRowSkipped = $this->languageRowSkipped | ($skipRow && !isset($this->currentSheetMergedRows[$row->getRowIndex() + 1]));
		$this->languageRowSkipped = $this->languageRowSkipped | $skipRow;
		$this->updateRowSettings();
		$this->previousRowType = isset($this->currentRowType) ? $this->currentRowType : null;
		$this->guessNewRowType();
	}

	private function processCell(PHPExcel_Cell $cell, $skipRow) {
		if (!isset($this->currentRowType)) {
			$this->currentRowType = $this->decodeRowType($cell);
		}

		if (!$skipRow) {
			switch ($this->currentRowType) {
				case self::DATA_ROW_TYPE:
					$this->processDataCell($cell);
					break;
				case self::STARTING_CONTROL_ROW_TYPE:
					$this->processCommand($cell);
					break;
				case self::ENDING_CONTROL_ROW_TYPE:
					$this->processTableEndCommand($cell);
					break;
				case self::CELL_CONTROL_ROW_TYPE:
					$this->processCellCommand($cell);
					break;
				default:
					// ignore cells
					break;
			}
        }

	}

	private function decodeRowType(PHPExcel_Cell $cell) {
		if ($this->insideTable()) {
			if ($cell->getCalculatedValue() != null) {
				if ($cell->getCalculatedValue() == self::TABLE_END_COMMAND) {
					return self::ENDING_CONTROL_ROW_TYPE;
				} else {
					return self::DATA_ROW_TYPE;
				}
			}
		} else {
			if ($cell->getCalculatedValue() == self::TABLE_START_COMMAND) {
				return self::STARTING_CONTROL_ROW_TYPE;
			}
		}
		return null;
	}

	private function processDataCell(PHPExcel_Cell $cell) {
		if ($this->currentTable->isColumnEnabled($cell->getColumn())) {
			$this->initializeRow();
			$this->detectPercentFlag($cell);

			$value = $this->computeValue($cell);
			$this->currentTable->getRow($this->currentRowIndex)->addData($value);
			$this->setGraphAxisValuesForRow($cell, $value);
			$this->setAnnualChangeValueForRow($cell, $value);
			$this->calculateSpan($this->currentTable->getRow($this->currentRowIndex), $cell);
		}

		if (strcmp($cell->getColumn(), $this->currentTable->getFoldingColumn()) == 0) {
			$this->setFoldingSettingForRow($cell);
		}
	}

	private function guessNewRowType() {
		if (isset($this->currentRowType)) {
			switch ($this->currentRowType) {
				case self::STARTING_CONTROL_ROW_TYPE:
					$this->currentRowType = self::CELL_CONTROL_ROW_TYPE;
					break;
				case self::CELL_CONTROL_ROW_TYPE:
					$this->currentRowType = self::DATA_ROW_TYPE;
					break;
				default:
				case self::DATA_ROW_TYPE:
				case self::ENDING_CONTROL_ROW_TYPE:
					unset($this->currentRowType);
					break;
			}
		}

	}

	private function insideTable() {
		return isset($this->currentTable);
	}

	private function updateRowSettings() {
		unset($this->currentCommand);
		$this->currentCommandExpectsData = false;

		if (isset($this->currentRowType) && ($this->currentRowType == self::DATA_ROW_TYPE)
			&& $this->currentTable->existsRow($this->currentRowIndex)
		) {
			if ($this->previousRowType == self::CELL_CONTROL_ROW_TYPE) {
				if ($this->currentTable->getFoldingColumn() != null) {
					$this->currentTableCellCount = $this->currentTable->getFoldingColumn();
				} else {
					$enabledColumns = $this->currentTable->getEnabledColumns();
					$this->currentTableCellCount = $enabledColumns[count($enabledColumns) - 1];
				}
			}
			$this->currentTable->getRow($this->currentRowIndex)->setHeaderRow($this->currentRowIndex == 1);
			$this->currentTable->getRow($this->currentRowIndex)->setRowNum($this->currentRowIndex);
			$this->currentRowIndex++;
		}
	}

	private function processTableEndCommand() {
		//echo $this->currentTable;
		$this->validateTable($this->currentTable);
		$this->tableCount++;
		$this->tableDao->save($this->currentTable);
		$this->currentTable = null;
		$this->currentTableCellCount = "X";
		$this->lastFoldingRowParentId = -1;
		$this->languageRowSkipped = false;
		unset($this->currentRowType);
	}

	private function processCommand(PHPExcel_Cell $cell) {
		if (!isset($this->currentCommand)) {
			$this->currentCommand = $cell->getCalculatedValue();
		}

		switch ($this->currentCommand) {
			case self::TABLE_START_COMMAND:
				$this->currentTable = new Table();
				$this->currentRowIndex = 1;
				$this->currentTable->setYear($this->year);
				unset($this->currentCommand);
				break;
			case self::TABLE_NAME_COMMAND:
				if ($this->currentCommandExpectsData) {
					$this->currentTable->setName($cell->getCalculatedValue());
					$this->currentCommandExpectsData = false;
					unset($this->currentCommand);
				} else {
					$this->currentCommandExpectsData = true;
				}
				break;
			case self::MIRROR_COMMAND :
				if ($this->currentCommandExpectsData) {
					$this->currentTable->setMirror($cell->getCalculatedValue());
					$this->currentCommandExpectsData = false;
					unset($this->currentCommand);
				} else {
					$this->currentTable->setMirror($this->currentTable->getName()); // set default value
					$this->currentCommandExpectsData = true;
				}
				break;
		}
	}

	private function processCellCommand(PHPExcel_Cell $cell) {
		if ($this->isEnabledColumnFlagPresent($cell)) {
			if ($this->cellHasMoreConfigurations($cell)) {
				$this->readAnualChangeConfiguration($cell);
				$this->readGraphConfiguration($cell);
			}
			if (!$this->languageColumnSkipped && $this->skipColSpecificToLanguage()) {
				$this->languageColumnSkipped = true;
			} else {
				$this->readRoundingConfiguration($cell);
				$this->defaultAnnualChangeConfiguration($cell);
				$this->currentTable->enableColumn($cell->getColumn());
			}
		} else if ($this->isFoldingColumnFlagPresent($cell)) {
			$this->currentTable->setFoldingColumn($cell->getColumn());
		}
	}

	private function readGraphConfiguration(PHPExcel_Cell $cell) {
		if (strpos($cell->getCalculatedValue(), self::GRAPH_X1_AXIS_FLAG, 1) > 0) {
			$this->currentTable->setX1Axis($cell->getColumn());
		} else if (strpos($cell->getCalculatedValue(), self::GRAPH_X2_AXIS_FLAG, 1) > 0) {
			$this->currentTable->setX2Axis($cell->getColumn());
		}
	}

	private function readAnualChangeConfiguration(PHPExcel_Cell $cell) {
		if (strpos($cell->getCalculatedValue(), self::ANNUAL_CHANGE_COMPUTATION_COLUMN_FLAG, 1) > 0) {
			$this->currentTable->setAnnualChangeComputationColumn($cell->getColumn());
		} else if (strpos($cell->getCalculatedValue(), self::ANNUAL_CHANGE_FLAG, 1) > 0) {
			$this->currentTable->setAnnualChangeColumn($cell->getColumn());
		}
	}

	private function readRoundingConfiguration(PHPExcel_Cell $cell) {
		$pos = strpos($cell->getCalculatedValue(), self::ROUNDING_FLAG, 1);
		$roundNum = 1;
		if ($pos > 0) {
			$roundNum = substr($cell->getCalculatedValue(), $pos + 1, 1);
		}
		$this->currentTable->setRounding($cell->getColumn(), $roundNum);
	}

	private function isFoldingColumnFlagPresent(PHPExcel_Cell $cell) {
		return strcasecmp($cell->getCalculatedValue(), self::FOLDING_COLUMN_FLAG) == 0;
	}

	private function isEnabledColumnFlagPresent(PHPExcel_Cell $cell) {
		return strncasecmp($cell->getCalculatedValue(), self::ACTIVE_COLUMN_FLAG, 1) == 0;
	}

	private function cellHasMoreConfigurations(PHPExcel_Cell $cell) {
		return strlen($cell->getCalculatedValue()) > 1;
	}

	private function skipRowSpecificToLanguage() {
		if (($this->year >0) && (isset($this->previousRowType))) {
			if ($this->previousRowType == self::CELL_CONTROL_ROW_TYPE) {
				return !$this->useFirstLanguage;
			} else if ($this->previousRowType == self::DATA_ROW_TYPE) {
				return $this->useFirstLanguage && !$this->languageRowSkipped;
			}
		}
		return false;
	}

	public function setUseFirstLanguage($useFirstLanguage) {
		$this->useFirstLanguage = $useFirstLanguage;
	}

	private function skipColSpecificToLanguage() {
		return ($this->useFirstLanguage && ($this->currentTable->enabledColumnCount() == 0))
			|| (!$this->useFirstLanguage && ($this->currentTable->enabledColumnCount() == 1));
	}

	private function initializeRow() {
		if (!$this->currentTable->existsRow($this->currentRowIndex)) {
			$this->currentTable->addRow($this->currentRowIndex);
			return true;
		}
		return false;
	}

	private function detectPercentFlag(PHPExcel_Cell $cell) {
		if (!isset($this->currentRowPercentValue)) {
			if (substr(ltrim($cell->getCalculatedValue()), 0, 1) == "%") {
				$this->currentRowPercentValue = 100;
			} else {
				$this->currentRowPercentValue = 1;
			}

		}
	}

	private function computeValue(PHPExcel_Cell $cell) {
		$value = $cell->getCalculatedValue();
		$this->validateCellValue($cell, $this->currentTable);
		$isNumber = is_numeric($value);
		return ($isNumber) ? ($value * $this->currentRowPercentValue) : $value;
	}

	private function setGraphAxisValuesForRow(PHPExcel_Cell $cell, $value) {
		if (is_numeric($value)) {
			if ($this->currentTable->getX1Axis() == $cell->getColumn()) {
				$this->currentTable->getRow($this->currentRowIndex)->setX1AxisValue($value);
			} else if ($this->currentTable->getX2Axis() == $cell->getColumn()) {
				$this->currentTable->getRow($this->currentRowIndex)->setX2AxisValue($value);
			}
		}
	}

	private function setAnnualChangeValueForRow(PHPExcel_Cell $cell, $value) {
		if ($this->currentTable->getAnnualChangeComputationColumn() == $cell->getColumn()) {
			$this->currentAnnualChangeValue = is_numeric($value) ? $value : -1;
		} else if ($this->currentTable->getAnnualChangeColumn() == $cell->getColumn()) {
			$this->currentTable->getRow($this->currentRowIndex)->setAnnualChangeValue($this->currentAnnualChangeValue);
			$this->currentAnnualChangeValue = -1;
		}
	}

	private function setFoldingSettingForRow(PHPExcel_Cell $cell) {
		$foldingRow = (strcmp(substr($cell->getCalculatedValue(), 0, 1), "2") == 0);
		$foldingParent = (strcmp(substr($cell->getCalculatedValue(), 0, 1), "1") == 0);

		$this->currentTable->getRow($this->currentRowIndex)->setParentRowNum(($foldingRow) ?
			$this->lastFoldingRowParentId : ($foldingParent ? 0 : -1));

		if ($foldingParent) {
			$this->lastFoldingRowParentId = $this->currentRowIndex;
		}
	}

	public function setTableDao(TableDao $tableDao) {
		$this->tableDao = $tableDao;
	}

	private function defaultAnnualChangeConfiguration(PHPExcel_Cell $cell) {
		if ($this->currentTable->enabledColumnCount() == 1) {
			$this->currentTable->setAnnualChangeComputationColumn($cell->getColumn());
		}
	}

	private function readSpanConfiguration(PHPExcel_Worksheet $sheet) {
		$this->currentSheetRowSpans = array();
		$this->currentSheetColSpans = array();
		foreach ($sheet->getMergeCells() as $mergedCell) {
			$cells = explode(":", $mergedCell);
			$startCell = $this->cellCoordinateToArray($cells[0]);
			$endCell = $this->cellCoordinateToArray($cells[1]);
			if ($this->columnsAreEqual($startCell, $endCell)) {
				$this->currentSheetRowSpans[$cells[0]] = $this->calculateRowSpan($startCell, $endCell);
				$this->setCurrentSheetMergedRows($startCell, $endCell);
			} else if ($this->rowsAreEqual($startCell, $endCell)) {
				$this->currentSheetColSpans[$cells[0]] = $this->calculateColSpan($startCell, $endCell);
			} else {
				$this->currentSheetRowSpans[$cells[0]] = $this->calculateRowSpan($startCell, $endCell);
				$this->currentSheetColSpans[$cells[0]] = $this->calculateColSpan($startCell, $endCell);
				$this->setCurrentSheetMergedRows($startCell, $endCell);
			}
		}
	}

	private function cellCoordinateToArray($coordinate) {
		$coordinateChars = str_split($coordinate);
		$column = "";
		$row = "";
		foreach ($coordinateChars as $coordinateChar) {
			if (is_numeric($coordinateChar)) {
				$row .= $coordinateChar;
			} else {
				$column .= $coordinateChar;
			}
		}
		return array(PHPExcel_Cell::columnIndexFromString($column), intval($row));
	}

	private function columnsAreEqual($startCell, $endCell) {
		return $startCell[0] == $endCell[0];
	}

	private function rowsAreEqual($startCell, $endCell) {
		return $startCell[1] == $endCell[1];
	}

	private function calculateSpan(TableRow $row, PHPExcel_Cell $cell) {
		$span = "";
		if (array_key_exists($cell->getCoordinate(), $this->currentSheetRowSpans)) {
			$span .= "R" . $this->currentSheetRowSpans[$cell->getCoordinate()];
		}
		if (array_key_exists($cell->getCoordinate(), $this->currentSheetColSpans)) {
			$span .= "C" . $this->currentSheetColSpans[$cell->getCoordinate()];
		}
		$row->addSpan($span);
	}

	private function calculateRowSpan($startCell, $endCell) {
		return $endCell[1] - $startCell[1] + 1;
	}

	private function calculateColSpan($startCell, $endCell) {
		return $endCell[0] - $startCell[0] + 1;
	}

	private function updateCurrentRowSpan(PHPExcel_Cell $cell) {
		if (array_key_exists($cell->getCoordinate(), $this->currentSheetRowSpans)) {
			$this->currentRowSpan = max($this->currentRowSpan, $this->currentSheetRowSpans[$cell->getCoordinate()]);
		}
	}

	private function setCurrentSheetMergedRows($startCell, $endCell) {
		$from = $startCell[1] < $endCell[1] ? $startCell[1] : $endCell[1];
		$to = $startCell[1] > $endCell[1] ? $startCell[1] : $endCell[1];
		for ($i = $from ; $i < $to ; $i++) {
			$this->currentSheetMergedRows[$i + 1]  = true;
		}
	}

	private function validateTable(Table $table) {
		if (($this->year != 0) && ($table->getX1Axis() == null)) {
			$this->message .= "\n\t<span style='color:orange;'>Warning: table '".$table->getName()."' does not have defined column for X1 axis in summary graph</span>";
		}
	}


	private function validateCellValue(PHPExcel_Cell $cell, Table $table) {
		if ($cell->getCalculatedValue() === "#VALUE!") {
			$this->message .= "\n\t<span style='color:red;'>Error: table '".$table->getName()."' contains wrong value in cell ". $cell->getCoordinate()."</span>";
		}
	}

}
