<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	jimport('joomla.application.component.modeladmin');
	require_once(JPATH_COMPONENT_SITE . '/models/cart/ShopDao.php');
	require_once('import/ShopTableDao.php');

	/**
	 * Config model of PosShop component
	 */
	class PosShopModelConfig extends JModelAdmin {

		public function getForm($data = array(), $loadData = true)
		{

			// Get the form.
			try {
				//throw new Exception(JText::_('JLIB_FORM_ERROR_NO_DATA'));
				$form = $this->loadForm('com_posshop', 'config');
			} catch (Exception $e) {
				echo "e";
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}

			if (empty($form)) {
				return false;
			}


			return $form;
		}
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

		public function createShopDao() {
			$dao = new ShopDao();
			$dao->setDb($this->getDbo());
			return $dao;
		}

		public function createShopTableDao() {
			$dao = new ShopTableDao();
			$dao->setDb($this->getDbo());
			return $dao;
		}

		public function saveConfig() {
			$config = array();
			$dao = $this->createShopTableDao();
			foreach (JRequest::get() as $key => $value) {
				$pos = strpos($key, "color");
				if ($pos !== FALSE) {
					$index = substr($key, 5);
					if (isset($config[$index])) {
						$config[$index]["color"] = $value;
					} else {
						$config[$index] = array();
						$config[$index]["color"] = $value;
					}
				} else {
					$pos = strpos($key, "imageurl");
					if ($pos !== FALSE) {
						$index = substr($key, 8);
						if (isset($config[$index])) {
							$config[$index]["image"] = $value;
						} else {
							$config[$index] = array();
							$config[$index]["image"] = $value;
						}
					}
				}
			}
			$dao->initializeTableConfig__($config);
		}

	}
