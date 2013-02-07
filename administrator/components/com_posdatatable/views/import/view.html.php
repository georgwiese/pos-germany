<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HelloWorlds View
	 */
	class PosDataTableViewImport extends JView {
		/**
		 * HelloWorlds view display method
		 * @return void
		 */
		function display($tpl = null) {
			JToolBarHelper::preferences('com_posdatatable');
			parent::display($tpl);
		}
	}
