<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla modelitem library
	jimport('joomla.application.component.modellist');
	require_once("compare/SummaryTable.php");
	/**
	 * Compare model of PosDataTable component
	 */
	class PosDataTableModelCompare extends JModel {

		private $isMultiYear;


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
			$this->setState("tableName", JRequest::getString("table"));
			$this->setState("year", JRequest::getInt("year"));
			$this->setState("row", JRequest::getInt("row"));
			$menuItemAlias = JRequest::getString("item");
			if (!empty($menuItemAlias)) {
				$this->setState("item", $menuItemAlias);
			}
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

		/**
		 * Get the message
		 * @return object The message to be displayed to the user
		 */
		public function getTableInfo() {
			$tableName = $this->getState('tableName');

			$db = $this->getDbo();
			$db->setQuery($db->getQuery(true)
				->select("year, x1_axis, x2_axis, round")
				->from("#__pos_data_table_info as p")
				->where("name = " . $db->quote($tableName)), 0, 1);

			if (!$tableInfo = $db->loadObject()) {
				$this->setError($db->getErrorMsg());
			}
			$this->isMultiYear = $tableInfo->year == 0;
			return $tableInfo;
		}

		public function getYear() {
			return $this->getState('year');
		}

		public function getTableName() {
			return $this->getState('tableName');
		}

		public function getRow() {
			return $this->getState('row');
		}

		public function getItem() {
			return $this->getState('item');
		}


		/**
		 * Get the message
		 * @return object The message to be displayed to the user
		 */
		public function getAnnualCompareData() {
			$db = $this->getDbo();
			if ($this->isMultiYear) {
				$query = $db->getQuery(true);
				$query->select("data")
					->from("#__pos_data_table a")
					->innerJoin("#__pos_data_table_info i on a.table_id = i.table_id")
					->where("row_num IN (1, " . $this->getRow() . ")")
					->where("name = " . $db->quote($this->getTableName()))
					->order("row_num");
				$db->setQuery($query);
			} else {
				$query = $db->getQuery(true);
				$query->select("a.x1_axis, a.x2_axis, year, data, row_num")
					->from("#__pos_data_table a")
					->innerJoin("#__pos_data_table_info i on a.table_id = i.table_id")
					->where("row_num IN (1, " . $this->getRow() . ")")
					->where("name = " . $db->quote($this->getTableName()))
					->order("row_num, year");
				$db->setQuery($query);
			}
			if (!$tableData = $db->loadObjectList()) {
				$this->setError($db->getErrorMsg(false));
			}
			return $tableData;
		}


	}
