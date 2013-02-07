<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 25.2.2012
	 * Time: 13:35
	 * To change this template use File | Settings | File Templates.
	 */
	class CartDao {

		const WORKING_COUNT = "workingCount";
		const RESIDENT_COUNT = "residentCount";
		const TOTAL_EXPEDITURES = "totalExpeditures";
		const PER_CAPTIVA_TAX = "perCaptivaTax";

		private $db;

		public function setDb(JDatabase $db) {
			$this->db = $db;
		}

		public function getDb() {
			return $this->db;
		}

		public function saveCart($cart) {
			$session = $this->createSession($this->getDb());
			$this->saveCart_($cart, $session, $this->getDb());
		}

		private function createSession(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->insert("#__pos_shop_session");
			$query->values("");

			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg());
			}
			return $db->insertid();
		}

		private function saveCart_($cart, $session, JDatabase $db) {
			if (sizeof($cart) > 0) {
				$query = $db->getQuery(true);
				$db->setQuery($query);
				$query->insert("#__pos_shop_cart");
				$query->columns("session_id, table_id, row_id, value");

				for ($i = 0; $i < sizeof($cart); $i++) {
					$query->values($session . ", " . $cart[$i][0] . ", " . $cart[$i][1] . ", " . $cart[$i][2]);
				}
				if (!$db->query()) {
					JError::raiseError(500, $db->getErrorMsg());
				}
			}

		}

		public function getSessionCount() {
			return $this->getSessionCount_($this->getDb());
		}

		private function getSessionCount_(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("count(session_id)");
			$query->from("#__pos_shop_session");
			$db->setQuery($query);
			return $db->loadResult();

		}

		public function getResults() {
			return $this->getResults_($this->getDb());
		}

		private function getResults_(JDatabase $db) {
			$query1 = $db->getQuery(true);
			$query1->select("count(*) as items, round(avg(value), 1) as avg, table_id, row_id");
			$query1->from("#__pos_shop_cart");
			$query1->group("table_id, row_id");

			$query = $db->getQuery(true);
			$query->select("items, avg, SUBSTRING(row_data, 1, LOCATE('|', row_data) - 1) as name");
			$query->from("#__pos_shop_table t");
			$query->innerJoin("(".$query1->__toString().") r ON r.row_id = t.row_id AND r.table_id = t.table_id");
			$query->order("items DESC");
			$db->setQuery($query);
			return $db->loadObjectList();
		}

		public function getConstants() {
			return $this->getConstants_($this->getDb());
		}

		private function getConstants_(JDatabase $db) {
			$query = $db->getQuery(true);
			$query->select("name, value");
			$query->from("#__pos_shop_constant");
			$db->setQuery($query);
			return $db->loadObjectList("name");
		}
	}
