<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
	jimport('joomla.application.component.modellist');
	require("import/ShopTableDao.php");

	/**
	 * Import model of PosShop component
	 */
	class PosShopModelImport extends JModel {

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
			parent::populateState();
		}

		public function createDao() {
			$dao = new ShopTableDao();
			$dao->setDb($this->getDbo());
			return $dao;
		}
	}
