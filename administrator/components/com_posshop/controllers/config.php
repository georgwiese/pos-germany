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
class PosShopControllerConfig extends JControllerForm
{
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
