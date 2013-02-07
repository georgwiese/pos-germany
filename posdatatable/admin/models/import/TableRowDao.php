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
	class TableRowDao extends AbstractDao {

		public function save(TableRow $row){
			$this->insert($row, $this->getDb());
		}

		public function delete(TableRow $row) {
		}

		private function insert(TableRow  $row, JDatabase $db) {
			$query = $db->getQuery(true);
			$query->insert("#__pos_data_table");
			$query->columns(array("row_num", "data", "x1_axis", "x2_axis", "table_id", "parent_id","is_header", "yearly_change", "span"));

			$values = $row->getRowNum().", ";
			$values .= $db->quote($db->escape(implode("|",$row->getData())."|")).", ";
			$values .= (($row->getX1AxisValue() == null) ? "null" : $row->getX1AxisValue()).", ";
			$values .= (($row->getX2AxisValue() == null) ? "null" : $row->getX2AxisValue()).", ".$row->getTableId().", ";
			$values .= (($row->getParentRowNum() === null) ? "-1" : $row->getParentRowNum()).", ";
			$values .= (($row->getHeaderRow()) ? "true, " : "false, ");
			$values .= (($row->getAnnualChangeValue() == null) ? "null" : $row->getAnnualChangeValue()).", ";
			$values .= $db->quote($row->getSpan());
			$query->values($values);
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}
			return $db->insertid();
		}
	}
