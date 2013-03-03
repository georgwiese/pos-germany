<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of PosWhatDoYouPay component
 */
class PosWhatDoYouPayController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'default'));
		// call parent behavior
		JToolBarHelper::title("PoS What Do You Pay");
		parent::display($cachable, $urlparams);
 

	}

}
