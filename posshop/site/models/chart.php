<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla modelitem library
	jimport('joomla.application.component.modellist');

	require_once(JPATH_COMPONENT_SITE . '/models/cart/ShopDao.php');

	/**
	 * HelloWorld Model
	 */
	class PosShopModelChart extends JModelList {

		/**
		 * Method to auto-populate the model state.
		 *
		 * This method should only be called once per instantiation and is designed
		 * to be called on the first call to the getState() method unless the model
		 * configuration flag to ignore the request is set.
		 *
		 * Note. Calling getState in this method will result in recursion.
		 *
		 * @return    void
		 * @since    1.6
		 */
		protected function populateState() {
			$this->setState("your", JRequest::getFloat("your"));
			$this->setState("total", JRequest::getFloat("total"));
			parent::populateState();
		}


		public function createShopDao() {
			$dao = new ShopDao();
			$dao->setDb($this->getDbo());
			return $dao;
		}

		public function getYour() {
			return $this->getState("your");
		}

		public function getTotal() {
			return $this->getState("total");
		}


	}
