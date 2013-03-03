<?php

// No direct access
	defined('_JEXEC') or die;

	class ConfigurationHelper {

		public static function getTemplatePostfix() {
			$params = JComponentHelper::getParams("com_poswhatdoyoupay");
			return $params->get("useTemplate");
		}
	}
