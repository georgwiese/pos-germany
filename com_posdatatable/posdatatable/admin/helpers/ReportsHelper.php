<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 12.6.2012
	 * Time: 7:06
	 * To change this template use File | Settings | File Templates.
	 */
	class ReportsHelper {
		public static function reportYearCountViolation($violations) {
			$firstRow = true;
			if (sizeof($violations) > 0) {
				echo "<br/><table style='border: 1px solid black;' cellpadding='1' cellspacing='0'>";
				foreach ($violations as $row) {
					if ($firstRow) {
						echo "<tr style='border: 1px solid black;'>";
						foreach ($row as $key => $value) {
							switch ($key) {
								case "name":
									echo "<th style='border: 1px solid black;' align='left'>" . JText::_('COM_POSDATATABLE_NAME_COLUMN') . "</th>\n";
									break;
								case "count":
									echo "<th style='border: 1px solid black;' align='left'>" . JText::_('COM_POSDATATABLE_COUNT_COLUMN') . "</th>\n";
									break;
								default:
									echo "<th style='border: 1px solid black;' align='left'>" . substr($key, 1) . "</th>\n";
									break;
							}
						}
						echo "</tr>";
						$firstRow = false;
					}
					echo "<tr style='border: 1px solid black;'>\n";

					foreach ($row as $key => $value) {
						switch ($key) {
							case "name":
								echo "<td style='border: 1px solid black;'>" . $value . "</td>\n";
								break;
							case "count":
								echo "<td style='border: 1px solid black;'>" . $value . "</td>\n";
								break;
							default:
								echo "<td style='border: 1px solid black;'>" . ($value ? "true" : "false") . "</td>\n";
								break;
						}
					}
					echo "</tr>\n";
				}
				echo "</table>";
			} else {
				echo " NONE";
			}

		}
	}
