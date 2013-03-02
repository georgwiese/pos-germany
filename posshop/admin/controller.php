<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of PosShop component
 */
class PosShopController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		self::addSubmenu(JRequest::getCmd('view', 'import'));
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'import'));
		JHtml::script('com_posshop/jscolor.js', false, true);
		JHtml::stylesheet('com_posshop/admin.css', array(), true);
		JToolBarHelper::title("PoS Shop");
		// call parent behavior
		parent::display($cachable, $urlparams);
 

	}

	private static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_POSSHOP_SUBMENU_IMPORT'),
			'index.php?option=com_posshop&view=import',
			$vName == 'import'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_POSSHOP_SUBMENU_CONFIGURATION'),
			'index.php?option=com_posshop&view=config',
			$vName == 'config'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_POSSHOP_SUBMENU_STATISTICS'),
			'index.php?option=com_posshop&view=stat',
			$vName == 'stat'
		);
	}

}
