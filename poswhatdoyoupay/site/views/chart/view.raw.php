<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * HTML View class for the PosWhatDoYouPay Component
	 */
	class PosWhatDoYouPayViewChart extends JView {

		// Overwriting JView display method
		function display($tpl = null) {
			// Display the view
			JFactory::getDocument()->setMimeEncoding('image/png');
			parent::display($tpl);
		}

	}
