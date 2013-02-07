<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * Import view of PosDataTable component
	 */
	class PosDataTableViewImport extends JView {

		function display($tpl = null) {
			JToolBarHelper::preferences('com_posdatatable');
			parent::display($tpl);
		}
	}
