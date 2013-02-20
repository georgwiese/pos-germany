<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla controller library
	jimport('joomla.application.component.controller');

	/**
	 * Hello World Component Controller
	 */
	class PosShopController extends JController {
		/**
		 * display task
		 *
		 * @return void
		 */
		function display($cacheable = false) {
			// set default view if not set
			$vName = JRequest::getCmd('view', 'cart');
			JRequest::setVar('view', $vName);
			if ($vName == "cart") {
				JHtml::script('com_posshop/yahoo-dom-event.js', false, true);
				JHtml::script('com_posshop/dragdrop-min.js', false, true);
				JHtml::script('com_posshop/slider-min.js', false, true);
				JHtml::stylesheet("com_posshop/slider.css", array(), true);
				JHtml::stylesheet("com_posshop/tooltip.css", array(), true);

			}
			parent::display($cacheable);

		}

	}
