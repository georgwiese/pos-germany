<?php

	// No direct access
	defined('_JEXEC') or die;

	jimport('joomla.application.component.controllerform');
	require_once(JPATH_COMPONENT . '/helpers/ImportHelper.php');

	class PosDataTableControllerImport extends JControllerForm {
		// TODO: make the filename safe
		/*	jimport('joomla.filesystem.file');
			$file['name'] = JFile::makeSafe($file['name']);

		// Move the uploaded file into a permanent location.
			if (isset( $file['name'] )) {

				// Make sure that the full file path is safe.
			$filepath = JPath::clean( $somepath.'/'.strtolower( $file['name'] ) );

				// Move the uploaded file.
			JFile::upload( $file['tmp_name'], $filepath );
			} */

		public function submit() {
			$importerHelper = new ImportHelper;
			$importerHelper->setTableDao($this->getModel()->createTableDao());
			$message = $importerHelper->import();
			$this->setRedirect(JRoute::_('index.php?option=com_posdatatable&view=import', false), "Tables reloaded!<br>" . $message);
			return true;
		}

		public function reset() {
			$this->getModel()->createTableDao()->clearDb();
			$this->setRedirect(JRoute::_('index.php?option=com_posdatatable&view=import', false), "Tables cleared!<br>");
			return true;
		}
	}
