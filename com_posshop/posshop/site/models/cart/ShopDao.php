<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 24.2.2012
	 * Time: 21:56
	 * To change this template use File | Settings | File Templates.
	 */
	class ShopDao {

		private $db;

		public function setDb(JDatabase $db) {
			$this->db = $db;
		}

		public function getDb() {
			return $this->db;
		}


		public function loadShopItems() {
			return $this->loadShopItems_($this->getDb());
		}

		public function loadShopItems_(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("table_id, row_id, row_data");
			$query->from("#__pos_shop_table");
			$query->order(array("table_id", "row_id"));
			$db->setQuery($query);
			return $db->loadObjectList();
		}

		public function loadTableConfig() {
			return $this->loadTableConfig_($this->getDb());

		}

		private function loadTableConfig_(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("table_id, picture, color");
			$query->from("#__pos_shop_table_config");
			$db->setQuery($query);
			return $db->loadObjectList("table_id");
		}
	}

