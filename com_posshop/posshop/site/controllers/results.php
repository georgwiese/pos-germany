<?php

	// No direct access
	defined('_JEXEC') or die;

	jimport('joomla.application.component.controllerform');
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
