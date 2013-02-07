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
	require_once(JPATH_COMPONENT . '/helpers/ImportHelper.php');
	/**
	 * Banner controller class.
	 *
	 * @package     Joomla.Administrator
	 * @subpackage  com_banners
	 * @since       1.6
	 */
class PosDataTableControllerImport extends JControllerForm
{
	public function submit() {
		$importerHelper = new ImportHelper;
		$importerHelper->setTableDao($this->getModel()->createTableDao());
		$message = $importerHelper->import();
		$this->setRedirect(JRoute::_('index.php?option=com_posdatatable&view=import', false), "Tables reloaded!<br>".$message);
		return true;
	}

	public function reset() {
		$this->getModel()->createTableDao()->clearDb();
		$this->setRedirect(JRoute::_('index.php?option=com_posdatatable&view=import', false), "Tables cleared!<br>");
		return true;
	}
}
