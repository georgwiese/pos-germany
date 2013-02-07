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
	require_once(JPATH_COMPONENT . '/helpers/ShopExcelParser.php');
	/**
	 * Banner controller class.
	 *
	 * @package     Joomla.Administrator
	 * @subpackage  com_banners
	 * @since       1.6
	 */
class PosShopControllerImport extends JControllerForm
{
	public function submit() {
		$parser = new ShopExcelParser();
		$parser->setTableDao($this->getModel()->createDao());
		$message = $parser->parseExcel($_FILES['data_file']['tmp_name'], "Current", JRequest::getBool("use_second"));
		$this->setRedirect(JRoute::_('index.php?option=com_posshop&view=import', false), "<pre>".$message."</pre>");
		return true;
	}

}
