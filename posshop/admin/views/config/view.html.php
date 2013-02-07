<?php
// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

// import Joomla view library
	jimport('joomla.application.component.view');
	jimport('joomla.form.helper');
	JFormHelper::loadFieldClass('media');

	/**
	 * Config view of PosShop component
	 */
	class PosShopViewConfig extends JView {

		private $config;
		private $tableNames;
		private $form;

		function display($tpl = null) {
			$this->populate($this->getModel());
			parent::display($tpl);
		}

		private function populate(PosShopModelConfig $model) {
			$shopDao = $model->createShopDao();
			$this->config = $shopDao->loadTableConfig();
			$shopTableDao = $model->createShopTableDao();
			$this->tableNames = $shopTableDao->getTableNames();
			$this->form = $this->get('Form');
		}

		public function getConfig() {
			return $this->config;
		}

		public function getTableNames() {
			return $this->tableNames;
		}

		public function getForm() {
			return $this->form;
		}

		public function createMediaField($id) {
			$mediaField = new JFormFieldMedia();
			$mediaField->setup(array("name" => "b", "type" => "media", "size" => "40",
				"label" => "COM_YOURCOMPONENT_IMG_LABEL", "hide_nome" => "1", "preview" => "true", "directory" => "/"), "");
		}


	}
