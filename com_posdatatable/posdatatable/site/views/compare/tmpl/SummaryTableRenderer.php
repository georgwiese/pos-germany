<?php

	// No direct access
	defined('_JEXEC') or die;

	class SummaryTableRenderer {

		static function printTables($tables) {
			foreach ($tables as $table) {
				self::printTable($table);
			}
		}

		static function printTable(SummaryTable $table) {
			if (sizeof($table->getData()) > 0) {
				echo "<table cellpadding='4' cellspacing='0' border='0' class='main-table'>";
				echo "<tr class='header'><th><h2>".JText::_('COM_POSDATATABLE_YEAR')."</h2></th>";
				self::printYearRow($table->getLabels());
				echo "</tr>";
				echo "<tr><td class='main'>" . $table->getYAxisName() . "</td>";
				self::printValueRow($table->getData(), $table->getPercentChar(), $table->getRound());
				echo "</tr>";
				echo "<tr><td class='main'>".JText::_('COM_POSDATATABLE_ANNUAL')."</td>";
				self::printDiffRow($table->getData());
				echo "</tr>";
				echo "</table>";
			}
		}

		static function printYearRow($years) {
			foreach ($years as $year) {
				echo "<th>$year</th>";
			}
		}

		static function printValueRow($data, $percentChar, $yAxisRound) {
			foreach ($data as $key => $value) {
				self::printValueCell($value, $key, $percentChar, $yAxisRound);
			}
		}

		static function printValueCell($item, $key, $percentChar, $yAxisRound) {
			if (($item != null) && ($item != "n.a.")) {
				$accuracy = (isset($yAxisRound[$key + 1]) ? $yAxisRound[$key + 1] : 1);
				echo "<td>" . number_format($item, $accuracy, ",", " ") . $percentChar . "</td>";
			} else {
				echo "<td>".JText::_('COM_POSDATATABLE_NA')."</td>";
			}
		}

		static function printDiffRow($data) {
			$lastValue = null;
			foreach ($data as $value) {
				$lastValue = self::printDiffCell($value, $lastValue);
			}
		}

		static function printDiffCell($item, $previousValue) {
			if (isset($previousValue)) {
				if (($item != null) && ($previousValue != null) && ($item != "n.a.")) {
					echo "<td>" . number_format((($item - $previousValue)
						/ $previousValue * 100), 1, ",", " ") . "%</td>";
				} else {
					echo "<td>".JText::_('COM_POSDATATABLE_NA')."</td>";
				}
			} else {
				echo "<td>-</td>";
			}
			return $item;
		}
	}