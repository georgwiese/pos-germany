<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HelloWorlds View
	 */
	class PosShopViewStat extends JView {

		private $results;
		private $total;

		/**
		 * HelloWorlds view display method
		 * @return void
		 */
		function display($tpl = null) {
			$this->populate($this->getModel());
			parent::display($tpl);
		}

		private function populate(PosShopModelStat $model) {
			$cartDao = $model->createDao();
			$this->results = $cartDao->getResults();
			$this->total = $cartDao->getSessionCount();
		}

		public function getResults() {
			return $this->results;
		}

		public function getTotal() {
			return $this->total;
		}
	}
