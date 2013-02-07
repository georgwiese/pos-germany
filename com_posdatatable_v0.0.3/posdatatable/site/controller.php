<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla controller library
	jimport('joomla.application.component.controller');

	/**
	 * PosDataTable component main controller
	 */
	class PosDataTableController extends JController {

		function display($cacheable = false, $urlparams = false) {
			// set default view if not set
			$vName = JRequest::getCmd('view', 'summary');
			JRequest::setVar('view', $vName);
			JHtml::script('com_posdatatable/utils.js', false, true);
			parent::display($cacheable, $urlparams);

		}

	}
