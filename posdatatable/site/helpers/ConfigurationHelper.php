<?php

// No direct access
	defined('_JEXEC') or die;

	require_once("pchart/pChart/pData.php");
	require_once("pchart/pChart/pChart.php");

	class ConfigurationHelper {

		private static $quadrantClasses = array("outcomes", "incomes", "spendiverse", "debts");

		public static function getCurrentYear() {
			$params = JComponentHelper::getParams("com_posdatatable");
			return $params->get("current_year");
		}

		public static function getSummaryPageTables() {
			$params = JComponentHelper::getParams("com_posdatatable");
			$summaryPageTable = array();
			for ($i = 0; $i < 4; $i++) {
				if ($params->get("quadrant".($i +1 )."TableEnabled") == 1) {
					$summaryPageTable[$i] = $params->get("quadrant".($i +1 )."TableName");
				}
			}
			return $summaryPageTable;

		}

		public static function getQuadrantClass($index) {
			return self::$quadrantClasses[$index];
		}

		public static function getQuadrantTitle($index) {
			$params = JComponentHelper::getParams("com_posdatatable");
			return $params->get("quadrant".($index + 1)."Title");
		}

		public static function useFirstLanguage() {
			$params = JComponentHelper::getParams("com_posdatatable");
			return !$params->get("useSecondLanguage");
		}
	}
