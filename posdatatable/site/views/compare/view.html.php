<?php

	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');
	require_once(JPATH_COMPONENT . '/helpers/SummaryTableHelper.php');

	/**
	 * HTML View class for the PosDataTable Component
	 */
	class PosDataTableViewCompare extends JView {
		private $year;
		private $item;
		private $row;
		private $summaryTables;
		private $tableName;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
            $this->year = $this->get("year");
            $this->item = $this->get("item");
            $this->row = $this->get("row");

            $this->tableName = $this->get("tableName");

			$tableInfo = $this->get('tableInfo');
			// Check for errors.
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}

			$annualData = $this->get('AnnualCompareData');
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			$this->summaryTables = SummaryTableHelper::getSummaryTables($tableInfo, $annualData);
			// Display the view
			parent::display($tpl);
		}

		public function getYear() {
			return $this->year;
		}

		public function getSummaryTables() {
			return $this->summaryTables;
		}

		public function getTableName() {
			return $this->tableName;
		}

		public function getRow() {
			return $this->row;
		}

		public function getItem() {
			return $this->item;
		}
	}
