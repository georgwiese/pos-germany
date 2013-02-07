<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');
	require_once(JPATH_COMPONENT . '/helpers/ReportsHelper.php');

	/**
	 * HelloWorlds View
	 */
	class PosDataTableViewInfo extends JView {

		private $tableNames;
		private $year;
		private $item;
		private $tableInfo;
		private $tableData;

		function display($tpl = null) {
			$this->populateView($this->getModel());
			parent::display($tpl);
		}

		private function populateView(PosDataTableModelInfo $model) {
			$this->tableNames = $model->getTableNames();
			$this->year = $this->get("year");
			$this->item = $this->get("item");
			$this->tableInfo = $model->getTableInfo();
			// Check for errors.
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
			}
			$this->tableData = $model->getTableData();
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode('<br />', $errors));
			}

		}

		public function getTableNames() {
			return $this->tableNames;
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
