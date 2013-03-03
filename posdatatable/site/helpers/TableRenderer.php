<?php

	// No direct access
	defined('_JEXEC') or die;

	require_once("table/Cell.php");
	require_once("NavigationHelper.php");

	class TableRenderer {

		const DESCRIPTION_CONTROL_CHAR = "#d";
		const SUMMARY_ROW_CONTROL_CHAR = "#s";

		public static function render($tableInfo, $tableData, $year, $tableWidth, $tableNumber, $currentLink, $compactMode = false) {

			if (!isset($tableInfo->table_id)) {
				echo "Error: table not exist";
				return;
			}

			echo "<table id='table$tableNumber' class='main-table' style='empty-cells:show' cellspacing=0 cellpadding=4"
				. ((isset($tableWidth)) ? " width='$tableWidth'" : "") . ">\n";
			$tableDescription = self::renderTableBody($tableData, $compactMode, $tableInfo, $currentLink, $year, $tableNumber);
			echo "</table>\n";

			if (!$compactMode) {
				self::renderTableDescription($tableNumber, $tableDescription);
			}
		}

		public static function renderTableBody($tableData, $compactMode, $tableInfo, $currentLink, $year, $tableNumber) {
			$tableDescription = JText::_('COM_POSDATATABLE_DEFAULT_TABLE_DESCRIPTION');
			$keepHeader = false;
			$wasSumRow = false;
			$round = explode("|", $tableInfo->round);

			foreach ($tableData as $row) {
				$rowData = explode("|", $row->data);

				$graphLink = self::getCompareViewLink($tableInfo, $row, $currentLink, $year, $compactMode);

				$controlSequenceIndex = self::getControlSequenceIndex($rowData[0]);
				$controlSequence = substr(ltrim($rowData[0]), $controlSequenceIndex, 2);

				$candidateTableDescription = self::parseTableDescription($controlSequence, $row, $rowData, $controlSequenceIndex);
				if ($candidateTableDescription != null) {
					$tableDescription = $candidateTableDescription;
				}

				$wasSumRow = $wasSumRow | $controlSequence == "#n";
				$wasSumRow = self::renderTableHeader($row, sizeof($tableData), $rowData, $keepHeader, $compactMode,
					$wasSumRow, $controlSequence);

				$keepHeader = self::renderRow($row, $rowData, $tableInfo, $round, $graphLink, $compactMode,
					$keepHeader, $tableNumber);

				echo "</tr>\n";
			}
			return $tableDescription;
		}

		public static function parseTableDescription($controlSequence, $row, $rowData, $controlSequenceIndex) {
			if (($controlSequence == self::DESCRIPTION_CONTROL_CHAR) && ($row->parent_id < 0)) {
				// load table description from 1 level only rows
				$tableDescription = substr($rowData[0], $controlSequenceIndex + 2);
				return $tableDescription;
			}
			return null;
		}

		public static function renderTableDescription($tableNumber, $tableDescription) {
			echo "<div id='td$tableNumber' class='table-description'>\n";
			echo "<div class='padding-10'>\n";
			echo "<h2>" . JText::_('COM_POSDATATABLE_TABLE_DESCRIPTION_LABEL') . "</h2>\n";
			echo "<p id='d$tableNumber'>" . $tableDescription . "</p>\n";
			echo "</div>\n";
			echo "</div>\n";
			echo "<div class='cb'>&nbsp;</div>\n";
		}

		public static function isLayer3Present($string) {
			$stringToTest = ltrim($string);
			return (strlen($stringToTest) > 0) &&
				(($stringToTest[0] == "-") || ($stringToTest[1] == "-"));
		}

		public static function getControlSequenceIndex($string) {
			$stringToTest = ltrim($string);
			$i = 0;
			while (($i < 3) && (strlen($stringToTest) > $i) && ($stringToTest[$i] != "#")) {
				$i++;
			}
			return ($i < 3) ? $i : -1;
		}

		public static function getCompareViewLink($tableInfo, $row, $currentLink, $year, $compactMode) {
			$x1AxisEnabled = ($tableInfo->x1_axis <> -1) && ($row->x1_axis <> -1);
			$x2AxisEnabled = ($tableInfo->x2_axis <> -1) && ($row->x2_axis <> -1);
			$summaryTableEnabled = !$compactMode || ($x1AxisEnabled || $x2AxisEnabled || ($tableInfo->year == 0));
			if ($summaryTableEnabled) {
				$itemLink = NavigationHelper::routeCompareView($currentLink, $year, $tableInfo->name, $row->row_num);
				return "onmouseover=\"this.style.cursor='pointer'\" onClick=\"parent.location='" .
					$itemLink . "'\"";
			}
			return null;
		}

		public static function renderTableHeader($row, $rowCount, $rowData, $keepHeader, $compactMode,
												 $sumRowDisabled, $controlSequence) {
			$layer3 = self::isLayer3Present($rowData[0]);
			$rowName = "";
			$style = "";
			$wasSumRow = $sumRowDisabled;
			if ($controlSequence == self::DESCRIPTION_CONTROL_CHAR) {
				$style = " style='display:none'";
			}

			if ($row->parent_id == 0) {
				$rowName = "name='p" . $row->row_num . "'";
			} else if ($row->parent_id > 0) {
				$rowName = "name='c" . $row->parent_id . "'";
				if (!$compactMode) {
					$style = " style='display:none'";
				}
			}

			if (self::isSummaryRow($controlSequence, $sumRowDisabled)) {
				echo "<tr class='sum' " . $rowName . $style . ">\n";
				$wasSumRow = true;
			} else {
				if (($row->row_num == 1) || $keepHeader) {
					echo "<tr class='header'>\n";
				} else if (($row->row_num == $rowCount) && (!$sumRowDisabled)) {
					echo "<tr class='sum' " . $rowName . $style . ">\n";
					$wasSumRow = true;
				} else if ($row->row_num > 1) {
					if ($layer3) {
						echo "<tr class='level2'>\n";
					} else {
						echo "<tr " . $rowName . $style . ">\n";
					}
				}
			}
			return $wasSumRow;
		}

		public static function isSummaryRow($controlSequence, $sumRowDisabled) {
			return ($controlSequence == self::SUMMARY_ROW_CONTROL_CHAR) && !$sumRowDisabled;
		}

		public static function renderRow($row, $rowData, $tableInfo, $round, $graphLink, $compactMode, $previousKeepHeader, $tableNumber) {
			$span = explode("|", $row->span);
			$trimedData = ltrim($rowData[0]);

			$controlIndex = 0;
			$isPercentValue = (strlen($trimedData) > 0) && ($trimedData[0] == "%");
			if ($isPercentValue) $controlIndex++;

			$isLevel3 = (strlen($trimedData) > ($controlIndex + 1)) && ($trimedData[$controlIndex] == "-");
			if ($isLevel3) $controlIndex++;

			$isControlSequence = (strlen($trimedData) > ($controlIndex + 1)) && ($trimedData[$controlIndex] == "#");
			$keepHeader = false;

			if ($compactMode && ($tableInfo->yearly_change > -1)) unset($rowData[sizeof($rowData) - 1]);
			for ($i = 0; $i < sizeof($rowData); $i++) {
				$cell = new Cell($rowData[$i], $graphLink);

				if (self::isFirstColumn($i)) {

					$cell->setCellStyle("");
					$cell->setFormattedValue($rowData[$i]);

					if (($isPercentValue) || ($isLevel3)) {
						$cell->setFormattedValue(substr($cell->getFormattedValue(), 1));
					}

					if ($isControlSequence) {
						self::stripControlCharacters($cell, $row);
					}

					$cell->initCellClass($row, $previousKeepHeader);

					if ($row->parent_id == 0) {
						$cell->initFoldingParentSettings($row->row_num, $tableNumber, $compactMode);
					}

				} else if (self::isAnnualChangeColumn($i, $tableInfo, $row)) {
					$cell->initValueWithAnnualChange($row->yearly_change1, $row->yearly_change2, $round[$i]);
				} else if (self::isNumericValue($cell->getFormattedValue(), $row)) {
					$cell->initValueWithNumber($rowData[$i], $round[$i], $isPercentValue);
				}

				if (self::isHeaderRow($row, $previousKeepHeader)) {
					if ($i == 0 && !$previousKeepHeader) {
						$cell->initSubHeaderTag();
					}
					$cell->initHeaderCell();
				}


				if (self::isFoldingChild($row)) {
					$cell->initFoldingChild($row->is_header, $i);
				}

				if (isset($span[$i])) {
					if ($cell->updateSpan($span[$i])) {
						$keepHeader = $previousKeepHeader || ($row->row_num == 1);
					}
				}
				echo $cell->render();
			}
			return $keepHeader;
		}

		public static function stripControlCharacters(Cell $cell, $row) {
			if ((substr($cell->getFormattedValue(), 0, 2) != self::DESCRIPTION_CONTROL_CHAR) || ($row->parent_id < 0)) {
				// strip control characters (except child descriptions)
				$cell->setFormattedValue(substr($cell->getFormattedValue(), 2));
			}
		}

		public static function isFoldingChild($row) {
			return $row->parent_id > 0;
		}

		public static function isHeaderRow($row, $previousKeepHeader) {
			return ($row->row_num == 1) || $previousKeepHeader;
		}

		public static function isNumericValue($formattedValue, $row) {
			return is_numeric($formattedValue) && ($row->row_num > 1);
		}

		public static function isAnnualChangeColumn($i, $tableInfo, $row) {
			return $i == $tableInfo->yearly_change && !$row->is_header;
		}

		public static function isFirstColumn($i) {
			return $i == 0;
		}
	}

?>