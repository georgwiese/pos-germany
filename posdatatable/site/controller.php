<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla controller library
	jimport('joomla.application.component.controller');

	/**
	 * Hello World Component Controller
	 */
	class PosDataTableController extends JController {
		/**
		 * display task
		 *
		 * @return void
		 */
		function display($cacheable = false) {
			// set default view if not set
			$vName = JRequest::getCmd('view', 'summary');
			JRequest::setVar('view', $vName);
			JHtml::script('com_posdatatable/utils.js', false, true);
			parent::display($cacheable);

		}

	}
