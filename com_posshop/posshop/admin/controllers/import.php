<?php
	// No direct access
	defined('_JEXEC') or die;

	jimport('joomla.application.component.controllerform');
	require_once(JPATH_COMPONENT . '/helpers/ShopExcelParser.php');

	class PosShopControllerImport extends JControllerForm {
		public function submit() {
			$parser = new ShopExcelParser();
			$parser->setTableDao($this->getModel()->createDao());
			$message = $parser->parseExcel($_FILES['data_file']['tmp_name'], "Current", JRequest::getBool("use_second"));
			$this->setRedirect(JRoute::_('index.php?option=com_posshop&view=import', false), "<pre>" . $message . "</pre>");
			return true;
		}

	}
