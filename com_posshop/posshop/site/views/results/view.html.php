<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosShop Component
	 */
	class PosShopViewResults extends JView {

		private $sum;
		private $cartDao;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
			if (!$this->populate($this->getModel())) {
				return false;
			}
			// Display the view
			parent::display($tpl);
		}

		private function populate(PosShopModelResults $model) {
			$this->sum = $model->getSum();
			$this->cartDao = $model->createCartDao();
			return true;
		}

		public function getSum() {
			return $this->sum;
		}

		public function getCartDao() {
			return $this->cartDao;
		}

	}
