<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 21.2.2012
	 * Time: 18:15
	 * To change this template use File | Settings | File Templates.
	 */
	require_once(JPATH_COMPONENT_SITE . '/models/results/CartDao.php');
	class ShopTableDao {

		private $db;

		static $config = array(1 => array("image" => "media/com_posshop/images/skolstvo.jpg", "color" => "#715B47"),
			array("image" => "media/com_posshop/images/socialny_system.jpg", "color" => "#E19D3B"),
			array("image" => "media/com_posshop/images/obrana.jpg", "color" => "#419D53"),
			array("image" => "media/com_posshop/images/zdravie.jpg", "color" => "#547353"),
			array("image" => "media/com_posshop/images/vnutro.jpg", "color" => "#0F9173"),
			array("image" => "media/com_posshop/images/podohospodarstvo.jpg", "color" => "#008BBA"),
			array("image" => "media/com_posshop/images/doprava.jpg", "color" => "#4364A6"),
			array("image" => "media/com_posshop/images/vystavba.jpg", "color" => "#6D4F99"),
			array("image" => "media/com_posshop/images/hospodarstvo.jpg", "color" => "#DD4F49"),
			array("image" => "media/com_posshop/images/financie.jpg", "color" => "#E65D56"),
			array("image" => "media/com_posshop/images/spravodlivost.jpg", "color" => "#F4873D"),
			array("image" => "media/com_posshop/images/kultura.jpg", "color" => "#E4CD2B"),
			array("image" => "media/com_posshop/images/zahranicie.jpg", "color" => "#33A4BA"),
			array("image" => "media/com_posshop/images/zivotne_prostredie.jpg", "color" => "#76B83D"),
			array("image" => "media/com_posshop/images/ostatne.jpg", "color" => "#4C566C")
		);

		public function setDb(JDatabase $db) {
			$this->db = $db;
		}

		public function getDb() {
			return $this->db;
		}



		public function deleteAll() {

			$query = $this->getDb()->getQuery(true);
			$query->delete("#__pos_shop_table");
			$this->getDb()->setQuery($query);
			if (!$this->getDb()->query()) {
				JError::raiseError(500, $this->getDb()->getErrorMsg());
			}
		}

		public function save(array $tableData) {
			$tableId = $this->getNextTableId($this->getDb());
			$this->save_($this->getDb(), $tableData, $tableId);
		}

		private function save_(JDatabase $db, array $tableData, $tableId) {
			$query = $db->getQuery(true);
			$query->insert("#__pos_shop_table");
			$query->columns(array("table_id", "row_id", "row_data"));
			$db->setQuery($query);

			for ($rowNum = 0; $rowNum < sizeof($tableData); $rowNum++) {
				$query->values($tableId . ", " . $rowNum . ", " . $query->quote($query->escape(implode("|", $tableData[$rowNum]))));
			}

			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

		}

		public function saveConstants($workingCount, $residentCount, $totalExpeditures, $perCaptivaTax) {
			$this->deleteContants();
			$this->saveConstants_($this->getDb(), $workingCount, $residentCount, $totalExpeditures, $perCaptivaTax);
		}

		private function deleteContants() {

			$query = $this->getDb()->getQuery(true);
			$query->delete("#__pos_shop_constant");
			$this->getDb()->setQuery($query);
			if (!$this->getDb()->query()) {
				JError::raiseError(500, $this->getDb()->getErrorMsg());
			}
		}

		private function saveConstants_(JDatabase $db, $workingCount, $residentCount, $totalExpeditures, $perCaptivaTax) {
			$query = $db->getQuery(true);
			$query->insert("#__pos_shop_constant");
			$query->columns(array("id", "name", "value"));
			$db->setQuery($query);

			$index = 1;
			$query->values($index++ . ", " .  $db->quote(CartDao::WORKING_COUNT) . ", " . $workingCount);
			$query->values($index++ . ", " .  $db->quote(CartDao::RESIDENT_COUNT) . ", " . $residentCount);
			$query->values($index++ . ", " .  $db->quote(CartDao::TOTAL_EXPEDITURES) . ", " . $totalExpeditures);
			$query->values($index . ", " .  $db->quote(CartDao::PER_CAPTIVA_TAX) . ", " . $perCaptivaTax);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

		}

		public function getTableNames() {
			return $this->getTableNames_($this->getDb());
		}

		public function getTableNames_(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("table_id, SUBSTRING(row_data, 1, LOCATE('|', row_data) - 1) as name");
			$query->from("#__pos_shop_table");
			$query->where("row_id = 0");
			$db->setQuery($query);
			return $db->loadObjectList();
		}

		private function getNextTableId(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("max(table_id) + 1");
			$query->from("#__pos_shop_table");
			$db->setQuery($query);
			if (!$nextId = $db->loadResult()) {
				$nextId = 1;
			}
			return $nextId;
		}

		public function getTableCount() {
			return $this->getNextTableId($this->getDb()) - 1;
		}

		public function initializeTableConfig() {
			$this->initializeTableConfig_($this->getDb(), self::$config);
		}

		public function initializeTableConfig__($config) {
			$this->initializeTableConfig_($this->getDb(), $config);
		}

		private function initializeTableConfig_(JDatabase $db, $config) {
			$query = $db->getQuery(true);
			$query->delete("#__pos_shop_table_config");
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

			$query->clear();
			$query->insert("#__pos_shop_table_config");
			$query->columns("table_id, picture, color");

			for ($i = 1; $i < sizeof($config) + 1; $i++) {
				$query->values($i . ", " . $db->quote($config[$i]["image"]) . ", " . $db->quote($config[$i]["color"]));
			}
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}

		}
	}
