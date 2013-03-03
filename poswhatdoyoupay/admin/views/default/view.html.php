<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	 * Default view of PosWhatDoYouPay component
	 */
	class PosWhatDoYouPayViewDefault extends JView {

		function display($tpl = null) {
			JToolBarHelper::preferences('com_poswhatdoyoupay');
			parent::display($tpl);
		}
	}
