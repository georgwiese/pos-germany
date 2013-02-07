<?php

	// No direct access
	defined('_JEXEC') or die;

	class SummaryTableHelper {

		static function getSummaryTables($tableInfo, $annualData, $dataAreForChart = false) {

			$summaryTables = array();
			$round = explode("|", $tableInfo->round);

			if (self::isMultiYearTable($tableInfo)) {
				$summaryTable = new SummaryTable();
				$summaryTable->setRound($round);

				$labels = explode("|", $annualData[0]->data);
				self::removeFirstElementFromArray($labels);
				$summaryTable->setLabels($labels);

				$data = explode("|", $annualData[1]->data);
				// first cell is Axis name
				$summaryTable->setYAxisName(self::stripControlChars($data[0], false));
				$summaryTable->setPercentChar(self::getPercentChar($data[0]));

				self::removeFirstElementFromArray($data);
				$summaryTable->setData($data);
				$summaryTables[0] = $summaryTable;

				if ($dataAreForChart) {
					$summaryTable->setChartName($summaryTable->getYAxisName());
					if ($summaryTable->getPercentChar() == "%") {
						$summaryTable->setYAxisName("%");
					}

				}

			} else {
				$yearCount = sizeof($annualData);
				$y1Axis = $tableInfo->x1_axis;
				$y2Axis = $tableInfo->x2_axis;
				foreach ($annualData as $row) {
					if ($row->row_num == 1) {
						$firstRow = explode("|", $row->data);
						$chartName = self::stripControlChars($firstRow[0]);

						if (($y1Axis > 0) && (!isset($summaryTables[0]))) {
							$summaryTable = new SummaryTable();
							self::initAnnualTable($summaryTable, $firstRow, $y1Axis, $yearCount, $round, $chartName, $dataAreForChart);
							$summaryTables[0] = $summaryTable;
						}
						if (($y2Axis > 0) && (!isset($summaryTables[1]))) {
							$summaryTable = new SummaryTable();
							self::initAnnualTable($summaryTable, $firstRow, $y2Axis, $yearCount, $round, $chartName, $dataAreForChart);
							$summaryTables[1] = $summaryTable;
						}


					} else {
						self::updateChartName($row, $summaryTables);
						if (($y1Axis > 0) && (!$dataAreForChart || ($row->x1_axis != null))) {
							$summaryTables[0]->addValue($row->x1_axis);
							$summaryTables[0]->addLabel($row->year);
						}
						if (($y2Axis > 0) && (!$dataAreForChart || ($row->x2_axis != null))) {
							$summaryTables[1]->addValue($row->x2_axis);
							$summaryTables[1]->addLabel($row->year);
						}
					}
				}
			}
			return $summaryTables;
		}

		public static function updateChartName($row, $summaryTables) {
			$chartSubname = self::stripControlChars(substr($row->data, 0, strpos($row->data, "|")));
			if ($chartSubname != null) {
				foreach ($summaryTables as $table) {
					$table->setChartName($chartSubname);
				}
			}
		}

		static public function initAnnualTable(SummaryTable $summaryTable, $firstRow, $y1Axis, $yearCount, $round,
											   $chartName, $dataAreForChart) {
			$summaryTable->setYAxisName(self::stripControlChars($firstRow[$y1Axis]));
			$summaryTable->setPercentChar(self::getPercentChar($firstRow[$y1Axis]));
			$yAxisRound = array_fill(1, $yearCount, $round[$y1Axis]);
			$yAxisRound[0] = 1;
			$summaryTable->setRound($yAxisRound);
			if ($dataAreForChart) {
				$summaryTable->setChartName($chartName);
			}

		}

		static public function isMultiYearTable($tableInfo) {
			return $tableInfo->year == 0;
		}

		static public function getPercentChar($data) {
			return ($data[0] == "%") ? "%" : "";
		}

		static public function removeFirstElementFromArray(&$labels) {
			array_shift($labels);
			unset($labels[sizeof($labels) - 1]);
		}

		static function stripControlChars($text) {
			$index = 0;
			if (strlen($text) > $index) {
				if ($text[$index] == "%") $index++;
			}
			if (strlen($text) > $index) {
				if ($text[$index] == "-") $index++;
			}
			if (strlen($text) > $index) {
				if ($text[$index] == "#") $index += 2;
			}
			return ($index > 0) ? substr($text, $index) : $text;
		}

	}