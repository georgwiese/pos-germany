<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
	jimport('joomla.application.component.modellist');

	require_once(JPATH_COMPONENT_SITE . '/helpers/ConfigurationHelper.php');

	/**
	 * Table model of PosDataTable component
	 */
	class PosDataTableModelTable extends JModelList {

		private $tableInfo;

		protected function populateState($ordering = null, $direction = null) {
			$menuItemAlias = JRequest::getString("item");
			if (!empty($menuItemAlias)) {
				$menuItem = JFactory::getApplication()->getMenu()->getItems('alias', $menuItemAlias, true);
				$this->setState("tableName", $menuItem->query["id"]);
				$this->setState("item", $menuItemAlias);
			}
			$year = JRequest::getInt("year", ConfigurationHelper::getCurrentYear());
			$this->setState("year", $year);
			parent::populateState($ordering, $direction);
		}

		public function getTable($type = 'PosDataTable', $prefix = 'PosDataTable', $config = array()) {
			return JTable::getInstance($type, $prefix, $config);
		}

		/**
		 * Get the message
		 * @return object The message to be displayed to the user
		 */
		public function getTableInfo() {
			$tableName = $this->getState('tableName');
			$year = $this->getState('year');
			if (isset($year)) {
				$db = $this->getDbo();
				$db->setQuery($db->getQuery(true)
					->select("table_id, name, year, x1_axis, x2_axis, round, yearly_change")
					->from("#__pos_data_table_info as p")
					->where("name = '" . $tableName . "' AND year IN (0, " . $year . ")"));

				if (!$tableInfo = $db->loadObject()) {
					$this->setError("No data found for year: " . $year . " and table: " . $tableName);
				}
			} else {
				$this->setError("Current year not specified, check Options in Pos Data Table component.");
			}

			$this->tableInfo = $tableInfo;
			return $tableInfo;
		}

		public function getYear() {
			return $this->getState('year');
		}

		public function getItem() {
			return $this->getState('item');
		}

		/**
		 * Get the message
		 * @return object The message to be displayed to the user
		 */
		public function getTableData() {
			$db = $this->getDbo();
			if ($this->tableInfo->yearly_change > -1) {
				$query1 = $db->getQuery(true);
				$query1->select("a.*")
					->from("#__pos_data_table a")
					->innerJoin("#__pos_data_table_info i on a.table_id = i.table_id")
					->where("year = " . $this->tableInfo->year)
					->where("name = " . $db->quote($this->tableInfo->name));

				$query2 = $db->getQuery(true);
				$query2->select("b.*")
					->from("#__pos_data_table b")
					->innerJoin("#__pos_data_table_info j on b.table_id = j.table_id")
					->where("year = " . ($this->tableInfo->year - 1))
					->where("name = " . $db->quote($this->tableInfo->name));

				$query3 = $db->getQuery(true);
				$query3->select("c.row_id, c.row_num, c.data, c.x1_axis, c.x2_axis, c.table_id, c.parent_id, c.is_header," .
					" c.yearly_change yearly_change1, d.yearly_change yearly_change2, c.span")
					->from("(" . $query1->__toString() . ") as c")
					->leftJoin("(" . $query2->__toString() . ") as d ON c.row_num = d.row_num")
					->order("c.row_num");

				$db->setQuery($query3);
			} else {
				$db->setQuery($db->getQuery(true)
					->select("row_id, row_num, data, x1_axis, x2_axis, table_id, parent_id,is_header, 0, 0, span ")
					->from("#__pos_data_table as p")
					->where("table_id =  " . $this->tableInfo->table_id)->order("row_id"));
			}
			if (!$tableData = $db->loadObjectList()) {
				$this->setError($db->getErrorMsg(false));
			}
			return $tableData;
		}
	}
