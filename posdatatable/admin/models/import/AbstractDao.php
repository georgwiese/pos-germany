<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 17.2.2012
	 * Time: 22:48
	 * To change this template use File | Settings | File Templates.
	 */
	abstract class AbstractDao {

		private $db;

		public function setDb(JDatabase $db) {
			$this->db = $db;
		}

		public function getDb() {
			return $this->db;
		}
	}
