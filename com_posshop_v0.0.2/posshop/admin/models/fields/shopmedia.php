<?php
	defined('JPATH_BASE') or die;
	jimport('joomla.form.formfield');

	class JFormFieldShopMedia extends JFormFieldMedia {

		protected $type = "ShopMedia";

		public function setId($id) {
			$this->id = $id;
			$this->name = $id;
		}

		public function setValue($value) {
			$this->value = $value;
		}
	}
