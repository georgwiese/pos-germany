<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla modelitem library
	jimport('joomla.application.component.modellist');
	require_once("table.php");
	require_once(JPATH_COMPONENT_SITE . '/helpers/ConfigurationHelper.php');

	/**
	 * HelloWorld Model
	 */
	class PosDataTableModelSummary extends PosDataTableModelTable {

		private $currentTableIndex = 0;


		/**
		 * Method to auto-populate the model state.
		 *
		 * This method should only be called once per instantiation and is designed
		 * to be called on the first call to the getState() method unless the model
		 * configuration flag to ignore the request is set.
		 *
		 * Note. Calling getState in this method will result in recursion.
		 *
		 * @return    void
		 * @since    1.6
		 */
		protected function populateState() {
			$this->setState('year', JRequest::getInt('year', ConfigurationHelper::getCurrentYear()));
			$this->setState("tableNames", ConfigurationHelper::getSummaryPageTables());
			parent::populateState();
		}

		/**
		 * Returns a reference to the a Table object, always creating it.
		 *
		 * @param    type    The table type to instantiate
		 * @param    string    A prefix for the table class name. Optional.
		 * @param    array    Configuration array for model. Optional.
		 * @return    JTable    A database object
		 * @since    1.6
		 */
		public function getTable($type = 'PosDataTable', $prefix = 'PosDataTable', $config = array()) {
			return JTable::getInstance($type, $prefix, $config);
		}

		public function setCurrentTable($index) {
			$tables = $this->getState("tableNames");
			if (isset($tables[$index])) {
				$this->setState("tableName", $tables[$index]);
				return true;
			}
			return false;
		}
	}
