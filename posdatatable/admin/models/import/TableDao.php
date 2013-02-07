<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require_once("AbstractDao.php");
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 17.2.2012
	 * Time: 21:56
	 * To change this template use File | Settings | File Templates.
	 */
	class TableDao extends AbstractDao {

		public function save(Table $table){
			$this->delete($table, $this->getDb());
			$this->insert($table, $this->getDb());
		}

		public function delete(Table $table, JDatabase $db) {
			$query = $db->getQuery(true);

			$innerQuery = $db->getQuery(true);
			$innerQuery->select("table_id");
			$innerQuery->from("#__pos_data_table_info");
			$innerQuery->where("name = ". $db->quote($db->escape($table->getName())));
			if ($table->getYear() != null) {
				$innerQuery->where("year = " . ((int) $table->getYear()));
			}

			$query->delete("#__pos_data_table");
			$query->where("table_id IN (" . $innerQuery->__toString().")");
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

			$query->clear();
			$query->delete("#__pos_data_table_info");
			$query->where("name = " . $db->quote($db->escape($table->getName())));
			if ($table->getYear() != null) {
				$query->where("year = " . ((int) $table->getYear()));
			}
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}
		}

		private function insert(Table $table, JDatabase $db) {
			$query = $db->getQuery(true);
			$query->insert("#__pos_data_table_info");
			$query->columns(array("name", "year", "x1_axis", "x2_axis", "round", "yearly_change"));
			$query->values($db->quote($table->getName()).", ". ((int) $table->getYear()).", ". ((int) $table->getX1AxisColumnIndex()).", "
				.((int) $table->getX2AxisColumnIndex()).", ". $db->quote(implode("|", $table->getRound())."|"). ", ". ((int) $table->getAnnualChangeColumnIndex()));
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

			$table->setId($db->insertid());
			$rowDao = new TableRowDao();
			$rowDao->setDb($this->getDb());
			foreach($table->getRows() as $row) {
				$row->setTableId($table->getId());
				$rowDao->save($row);
			}
		}

		public function clearDb() {
			$query = $this->getDb()->getQuery(true);

			$query->delete("#__pos_data_table");
			$this->getDb()->setQuery($query);
			if (!$this->getDb()->query()) {
				JError::raiseError(500, $this->getDb()->getErrorMsg());
			}

			$query->clear();
			$query->delete("#__pos_data_table_info");
			if (!$this->getDb()->query()) {
				JError::raiseError(500, $this->getDb()->getErrorMsg());
			}
		}
	}
