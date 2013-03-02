<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require_once("PHPExcel/IOFactory.php");
	PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp, array(' memoryCacheSize ' => '20MB'));
	PHPExcel_Settings::setLocale("sk-sk");

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 20.2.2012
	 * Time: 21:16
	 * To change this template use File | Settings | File Templates.
	 */
	class ShopExcelParser {

		private $commonTableHeader;
		private $inTable;
		private $lastRowDetected;
		private $currentTable;
		private $currentTableName;
		private $tableDao;
		private $message;
		private $tableCount;
		private $actualTableNameColumn;
		private $actualDataColumns;
		private $actualHeaderRow;

		private static $dataColumns = array("B", "E", "F", "G", "H", "I");
		private static $dataColumns2ndLang = array("D", "E", "F", "G", "H", "J");
		private static $tableNameColumn = "A";
		private static $tableNameColumn2ndLang = "C";
		private static $headerColumns = array("E", "F", "G");
		private static $cellValueRounding = array("E" => 2, "F" => 0, "G" => 0);
		private static $headerRow = 3;
		private static $headerRow2ndLang = 4;

		const FIRST_DATA_ROW = 5;

		const CONSTANT_ROW = 2;
		const RESIDENT_COUNT_COL = "E";
		const WORKING_COUNT_COL = "F";
		const TOTAL_EXPEDITURES_COL = "G";
		const PER_CAPTIVA_TAX_COL = "H";

		public function parseExcel($fileName, $worksheetName, $useSecondLanguage) {
			$started = time();
			$this->tableCount = 0;
			$this->message = "";
			$excelFile = PHPExcel_IOFactory::load($fileName);
			$this->message .= "Processing file: " . $fileName."\n";

			$this->actualDataColumns = $useSecondLanguage ? self::$dataColumns2ndLang : self::$dataColumns;
			$this->actualTableNameColumn = $useSecondLanguage ? self::$tableNameColumn2ndLang : self::$tableNameColumn;
			$this->actualHeaderRow = $useSecondLanguage ? self::$headerRow2ndLang : self::$headerRow;

			$worksheet = $excelFile->getSheetByName($worksheetName);
			if ($worksheet !== null) {
				$this->parseWorksheet($worksheet);
				$this->message .= "\n File processed in: " . (time() - $started) . " seconds.";
				$this->message .= "\n Tables found: " . $this->tableCount;
			} else {
				$this->message .= "\n <span style='color:red;'>Error: sheet 'Current' not found in the excel.</span>";
			}
			return $this->message;
		}

		private function parseWorksheet(PHPExcel_Worksheet $worksheet) {
			$this->tableDao->deleteAll();
			$rowIndex = 1;
			$this->lastRowDetected = false;
			while (!$this->lastRowDetected) {
				$this->parseRow($rowIndex++, $worksheet);
			}
		}

		private function parseRow($rowIndex, PHPExcel_Worksheet $worksheet) {
			if ($rowIndex == $this->actualHeaderRow) {
				$this->commonTableHeader = $this->getTableHeader($worksheet, $rowIndex);
			} else if ($rowIndex == self::CONSTANT_ROW) {
				$this->parseConstants($worksheet, $rowIndex);
			} else if ($rowIndex >= self::FIRST_DATA_ROW) {
				$tableNameCandidate = $this->getCellValue($worksheet, $this->actualTableNameColumn, $rowIndex);
				if ($this->isTableNameCell($tableNameCandidate)) {
					if ($this->inTable) {
						$this->tableDao->save($this->currentTable);
						$this->tableCount++;
					} else {
						$this->inTable = true;
					}
					$this->currentTableName = $tableNameCandidate;
					$this->currentTable = array();
					array_push($this->currentTable, $this->getFirstRow());
				} else {
					$this->detectLastRow($worksheet, $rowIndex);
					if ($this->lastRowDetected) {
						$this->tableCount++;
						$this->tableDao->save($this->currentTable);
					} else {
						array_push($this->currentTable, $this->getDataForCurrentRow($worksheet, $rowIndex, $this->actualDataColumns));
					}
				}
			}
		}

		private function detectLastRow(PHPExcel_Worksheet $worksheet, $rowIndex) {
			$lastRowCandidate = $this->getCellValue($worksheet, "B", $rowIndex);
			$this->lastRowDetected = !isset($lastRowCandidate) || (strlen($lastRowCandidate) == 0);
		}

		private function isTableNameCell($tableNameCandidate) {
			return isset($tableNameCandidate) && (strlen($tableNameCandidate) != 0);
		}

		private function getDataForCurrentRow(PHPExcel_Worksheet $worksheet, $rowIndex, $columnDefinition) {
			$data = array();
			foreach ($columnDefinition as $columnIndex) {
				$value = $this->getCellValue($worksheet, $columnIndex, $rowIndex);
				if (array_key_exists($columnIndex, self::$cellValueRounding) && is_numeric($value)) {
					$value = round(floatval($value), self::$cellValueRounding[$columnIndex]);
				}
				array_push($data, $value);
			}
			return $data;
		}

		private function getCellValue(PHPExcel_Worksheet $worksheet, $columnIndex, $rowIndex) {
			$cell = $worksheet->getCell($columnIndex . $rowIndex);
			return $cell->getCalculatedValue();
		}

		private function getTableHeader($worksheet, $rowIndex) {
			return $this->getDataForCurrentRow($worksheet, $rowIndex, self::$headerColumns);
		}

		private function getFirstRow() {
			return array_merge(array($this->currentTableName), $this->commonTableHeader);
		}

		public function setTableDao(ShopTableDao $tableDao) {
			$this->tableDao = $tableDao;
		}

		private function parseConstants(PHPExcel_Worksheet $worksheet, $rowIndex) {
			$residentCount = $this->getCellValue($worksheet, self::RESIDENT_COUNT_COL, $rowIndex);
			$workingCount = $this->getCellValue($worksheet, self::WORKING_COUNT_COL, $rowIndex);
			$totalExpeditures = $this->getCellValue($worksheet, self::TOTAL_EXPEDITURES_COL, $rowIndex);
			$perCaptivaTax = $this->getCellValue($worksheet, self::PER_CAPTIVA_TAX_COL, $rowIndex);
			$this->tableDao->saveConstants($workingCount, $residentCount, $totalExpeditures, $perCaptivaTax);
		}
	}
