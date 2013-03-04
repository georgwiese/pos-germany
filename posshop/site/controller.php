<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla controller library
	jimport('joomla.application.component.controller');

	/**
	 * PosShop component main controller
	 */
	class PosShopController extends JController {

		function display($cacheable = false, $urlparams = false) {
			// set default view if not set
			$vName = JRequest::getCmd('view', 'cart');
			JRequest::setVar('view', $vName);
			if ($vName == "cart") {
				JHtml::script('com_posshop/yahoo-dom-event.js', false, true);
				JHtml::script('com_posshop/dragdrop-min.js', false, true);
				JHtml::script('com_posshop/slider-min.js', false, true);
				JHtml::stylesheet("com_posshop/buttonsets.css", array(), true);
				// JQuery UI
				JHtml::stylesheet("http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css", array(), true);
				JHtml::script('http://code.jquery.com/jquery-1.9.1.min.js', false, true);
				JHtml::script('http://code.jquery.com/ui/1.10.1/jquery-ui.min.js', false, true);

			}
			parent::display($cacheable, $urlparams);

		}

	}
