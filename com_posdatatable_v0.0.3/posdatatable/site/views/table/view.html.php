<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosDataTable Component
	 */
	class PosDataTableViewTable extends JView {

		private $year;
		private $item;
		private $tableInfo;
		private $tableData;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
			$this->year = $this->get("year");
			$this->item = $this->get("item");
			$this->tableInfo = $this->get('TableInfo');
			// Check for errors.
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			$this->tableData = $this->get('TableData');
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			// Display the view
			parent::display($tpl);
		}

		public function getYear() {
			return $this->year;
		}

		public function getTableData() {
			return $this->tableData;
		}

		public function getTableInfo() {
			return $this->tableInfo;
		}

		public function getItem() {
			return $this->item;
		}


	}
