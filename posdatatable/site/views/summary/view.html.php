<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosDataTable Component
	 */
	class PosDataTableViewSummary extends JView {

		private $year;
		private $quadrantTables;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
			$this->year = $this->get("year");
			if (!$this->populate($this->getModel())) {
				return false;
			}
			// Display the view
			parent::display($tpl);
		}

		private function populate(PosDataTableModelSummary $model) {
			for ($i = 0; $i < 4; $i++) {
				if ($model->setCurrentTable($i)) {
					$tableInfo = $model->getTableInfo();
					// Check for errors.
					if (count($errors = $this->get('Errors'))) {
						JError::raiseError(500, implode('<br />', $errors));
						return false;
					}
					$tableData = $model->getTableData();
					if (count($errors = $this->get('Errors'))) {
						JError::raiseError(500, implode('<br />', $errors));
						return false;
					}
					$this->quadrantTables[$i] = array($tableInfo, $tableData);
				}
			}
			return true;
		}

		public function getYear() {
			return $this->year;
		}

		public function getQuadrantTableInfo($index) {
			return $this->quadrantTables[$index][0];
		}

		public function getQuadrantTableData($index) {
			return $this->quadrantTables[$index][1];
		}

		public function isQuadrantEnabled($index) {
			return isset($this->quadrantTables[$index]);
		}
	}
