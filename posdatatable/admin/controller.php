<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class PosDataTableController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false) 
	{
		self::addSubmenu(JRequest::getCmd('view', 'import'));
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'import'));
		JHtml::script('com_posdatatable/utils.js', false, true);

		// call parent behavior
		parent::display($cachable);
 

	}

	private static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_POSDATATABLE_SUBMENU_IMPORT'),
			'index.php?option=com_posdatatable&view=import',
			$vName == 'import'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_POSDATATABLE_SUBMENU_REPORTS'),
			'index.php?option=com_posdatatable&view=reports',
			$vName == 'reports'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_POSDATATABLE_SUBMENU_INFO'),
			'index.php?option=com_posdatatable&view=info',
			$vName == 'info'
		);
	}

}
