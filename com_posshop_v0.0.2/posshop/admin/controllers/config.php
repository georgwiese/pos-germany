<?php

	// No direct access
	defined('_JEXEC') or die;

	jimport('joomla.application.component.controllerform');
	class PosShopControllerConfig extends JControllerForm {
		public function submit() {
			$this->getModel()->saveConfig();
			$this->setRedirect(JRoute::_('index.php?option=com_posshop&view=config', false), "Configuration updated!");
			return true;
		}

		public function reset() {
			$this->getModel()->createShopTableDao()->initializeTableConfig();
			$this->setRedirect(JRoute::_('index.php?option=com_posshop&view=config', false), "Configuration reseted!");
			return true;
		}

	}
