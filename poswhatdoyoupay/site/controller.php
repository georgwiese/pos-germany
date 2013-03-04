<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla controller library
	jimport('joomla.application.component.controller');

	/**
	 * PosWhatDoYouPay component main controller
	 */
	class PosWhatDoYouPayController extends JController {

		function display($cacheable = false, $urlparams = false) {
			// set default view if not set
			$vName = JRequest::getCmd('view', 'calc');
			JRequest::setVar('view', $vName);
			if ($vName == "calc") {
				JHtml::script('com_poswhatdoyoupay/verify.js', false, true);
			}
			parent::display($cacheable, $urlparams);

		}

	}
