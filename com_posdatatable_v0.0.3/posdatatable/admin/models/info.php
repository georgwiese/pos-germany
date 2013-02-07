<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
	jimport('joomla.application.component.modellist');
	require_once(JPATH_COMPONENT_SITE . '/models/table.php');

	class PosDataTableModelInfo extends PosDataTableModelTable {

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
		protected function populateState($ordering = null, $direction = null) {
			if (JRequest::getString("tableWithYear") != "") {
				$tableWithYear = explode("|", JRequest::getString("tableWithYear"));
			} else {
				$tableWithYear = $this->getSomeTable();
			}
			$this->setState("tableName", $tableWithYear[0]);
			$this->setState("year", JRequest::getInt("year", $tableWithYear[1]));
		}

		public function getTableNames() {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select("name, year");
			$query->from("#__pos_data_table_info");
			$query->where("year <> 0 ");
			$query->group("name, year");
			$db->setQuery($query);
			$tableData = $db->loadObjectList();
			if ($tableData === null) {
				$this->setError($db->getErrorMsg(false));
			}
			return $tableData;
		}

		public function getSomeTable() {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select("name, year");
			$query->from("#__pos_data_table_info");
			$query->where("year <> 0 ");
			$query->group("name, year");
			$db->setQuery($query, 0, 1);
			$tableData = $db->loadRow();
			if ($tableData === null) {
				$this->setError($db->getErrorMsg(false));
			}
			return $tableData;
		}
	}