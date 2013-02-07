<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla modelitem library
	jimport('joomla.application.component.modellist');

	require_once(JPATH_COMPONENT_SITE . '/models/results/CartDao.php');

	/**
	 * HelloWorld Model
	 */
	class PosShopModelResults extends JModelList {

		static $fieldPrefix = "srv";
		static $fieldPrefixLength = 3;

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
			$this->collectCart();
			parent::populateState();
		}

		protected function collectCart() {
			$sum = 0;
			$cart = array();
			foreach (JRequest::get() as $key => $value) {
				if (strstr($key, self::$fieldPrefix) != FALSE) {
					$sum += floatval($value);
					if ($value > 0) {
						$item = explode("_", substr($key, self::$fieldPrefixLength));
						array_push($item, $value);
						array_push($cart, $item);
					}
				}
			}
			$this->setState("sum", $sum);
			$this->setState("cart", $cart);
		}

		public function createCartDao() {
			$dao = new CartDao();
			$dao->setDb($this->getDbo());
			return $dao;
		}

		public function getCart() {
			return $this->getState("cart");
		}

		public function getSum() {
			return $this->getState("sum");
		}


	}
