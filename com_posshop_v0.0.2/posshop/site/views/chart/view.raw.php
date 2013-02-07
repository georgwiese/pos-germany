<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosShop Component
	 */
	class PosShopViewChart extends JView {
		private $your = 0;
		private $total = 1;
		private $sum = 0;
		private $table;
		private $config;

		// Overwriting JView display method
		function display($tpl = null) {
			$this->populate($this->getModel());
			JFactory::getDocument()->setMimeEncoding('image/png');
			// Display the view
			parent::display($tpl);
		}


		private function populate(PosShopModelChart $model) {
			$this->your = $model->getYour();
			$this->total = $model->getTotal();
			$dao = $model->createShopDao();
			$this->config = $dao->loadTableConfig();
			$this->table = $dao->loadShopItems();
		}

		public function getSum() {
			return $this->sum;
		}

		public function getTable() {
			return $this->table;
		}

		public function getTotal() {
			return $this->total;
		}

		public function getYour() {
			return $this->your;
		}

		public function getConfig() {
			return $this->config;
		}


	}
