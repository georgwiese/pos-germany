<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');
	require_once(JPATH_COMPONENT . '/helpers/SummaryTableHelper.php');

	/**
	 * HTML View class for the PosDataTable Component
	 */
	class PosDataTableViewChart extends JView {
		private $year;
		private $item;
		private $row;
		private $chartTables;
		private $tableName;
		private $y1Axis;
		private $y2Axis;
		private $multiYear;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
			$this->year = $this->get("year");
			$this->item = $this->get("item");
			$this->row = $this->get("row");
			$this->tableName = $this->get("tableName");
			$tableInfo = $this->get('tableInfo');
			// Check for errors.
			if (count($errors = $this->get('Errors'))) {
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			$this->y1Axis = $tableInfo->x1_axis > 0;
			$this->y2Axis = $tableInfo->x2_axis > 0;
			$this->multiYear = $tableInfo->year == 0;

			$annualData = $this->get('AnnualCompareData');
			if (count($errors = $this->get('Errors'))) {
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			JFactory::getDocument()->setMimeEncoding('image/png');

			$this->chartTables = SummaryTableHelper::getSummaryTables($tableInfo, $annualData, true);
			// Display the view
			parent::display($tpl);
		}

		public function getYear() {
			return $this->year;
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

		public function getChartTables() {
			return $this->chartTables;
		}

		public function getY1Axis() {
			return $this->y1Axis;
		}

		public function getY2Axis() {
			return $this->y2Axis;
		}

		public function getMultiYear() {
			return $this->multiYear;
		}


	}
