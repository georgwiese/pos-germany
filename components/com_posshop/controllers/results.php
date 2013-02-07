<?php
	/**
	 * @package     Joomla.Administrator
	 * @subpackage  com_banners
	 *
	 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE.txt
	 */

// No direct access
	defined('_JEXEC') or die;

	jimport('joomla.application.component.controllerform');
	/**
	 * Banner controller class.
	 *
	 * @package     Joomla.Administrator
	 * @subpackage  com_banners
	 * @since       1.6
	 */
	class PosShopControllerResults extends JControllerForm {

		public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true)) {
			return parent::getModel($name, $prefix, array('ignore_request' => false));
		}

		public function calculate() {
			$this->saveCart($this->getModel());
			$this->display();
			return true;
		}

		private function saveCart(PosShopModelResults $model) {
			$dao = $model->createCartDao();
			$dao->saveCart($model->getCart());
		}
	}
