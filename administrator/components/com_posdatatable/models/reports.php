<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
	jimport('joomla.application.component.modellist');

	class PosDataTableModelReports extends JModel {

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
			parent::populateState();
		}

		public function getYearList() {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select("year");
			$query->from("#__pos_data_table_info");
			$query->order("year");
			$query->group("year");
			$db->setQuery($query);
			if (!$years = $db->loadColumn()) {
				$this->setError($db->getErrorMsg(false));
			}
			return $years;
		}

		public function getTableCountReport($years) {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select(implode(", ", $this->constructSelectClause($years)));
			$index = 1;
			$query->from($this->constructBaseQuery());
			foreach ($years as $year) {
				$query->leftJoin("#__pos_data_table_info y" . $index . " ON (y.name = y" . $index . ".name) AND y" . $index . ".year = " . $year);
				$index++;
			}
			$query->where($this->constructCountCondition($years));
			$query->order("y1.name");
			$db->setQuery($query);
			$tableData = $db->loadAssocList();
			if ($tableData === null) {
				$this->setError($db->getErrorMsg(false));
			}
			return $tableData;
		}

		private function constructSelectClause($years) {
			$columns = array("y.name");
			$index = 1;
			$sumColumn = array();
			foreach ($years as $year) {
				array_push($columns, "!isnull(y" . $index . ".year) as y" . $year);
				array_push($sumColumn, "!isnull(y" . $index . ".year)");
				$index++;
			}
			array_push($columns, implode(" + ", $sumColumn) . " as count");
			return $columns;
		}

		private function constructBaseQuery() {
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select("name");
			$query->from("#__pos_data_table_info");
			$query->where("year <> 0 ");
			$query->group("name");
			return "(" . $query . ") y";
		}

		private function constructCountCondition($years) {
			$index = 1;
			$sumColumn = array();
			foreach ($years as $year) {
				array_push($sumColumn, "!isnull(y" . $index . ".year)");
				$index++;
			}
			return implode(" + ", $sumColumn) . " < " . sizeof($years);
		}
	}