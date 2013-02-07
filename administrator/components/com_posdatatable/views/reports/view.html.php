<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');
	require_once(JPATH_COMPONENT . '/helpers/ReportsHelper.php');

	/**
	 * HelloWorlds View
	 */
	class PosDataTableViewReports extends JView {

		private $tableCountReport;
		private $tableYears;
		private $annualTablesPresent;
		/**
		 * HelloWorlds view display method
		 * @return void
		 */
		function display($tpl = null) {
			$years = $this->getModel()->getYearList();
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			$years = $this->detectAnnualTables($years);
			$this->tableYears = $years;

			$this->tableCountReport = $this->getModel()->getTableCountReport($years);
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}

			parent::display($tpl);
		}

		public function detectAnnualTables($years) {
			if ((sizeof($years) > 0) && ($years[0] == 0)) {
				$this->annualTablesPresent = "true";
				array_shift($years);
				return $years;
			} else {
				$this->annualTablesPresent = "false";
				return $years;
			}
		}

		public function getTableCountReport() {
			return $this->tableCountReport;
		}

		public function getTableYears() {
			return $this->tableYears;
		}

		public function getAnnualTablesPresent() {
			return $this->annualTablesPresent;
		}

	}
