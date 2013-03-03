<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla view library
	jimport('joomla.application.component.view');

	require_once(JPATH_COMPONENT_SITE . '/helpers/ConfigurationHelper.php');

	/**
	 * HTML View class for the PosWhatDoYouPay Component
	 */
	class PosWhatDoYouPayViewResults extends JView {

		// Overwriting JView display method
		function display($tpl = null) {
			// Display the view
			parent::display(ConfigurationHelper::getTemplatePostfix());
		}

	}