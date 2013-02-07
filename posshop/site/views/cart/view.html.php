<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosShop Component
	 */
	class PosShopViewCart extends JView {

		private $shopDao;

		// Overwriting JView display method
		function display($tpl = null) {
			// Assign data to the view
			if (!$this->populate($this->getModel())) {
				return false;
			}
			// Display the view
			parent::display($tpl);
		}

		private function populate(PosShopModelCart $model) {
			$this->shopDao = $model->createTableDao();
			return true;
		}

		public function getShopDao() {
			return $this->shopDao;
		}

	}
