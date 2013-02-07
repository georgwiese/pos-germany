<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	require_once(JPATH_COMPONENT . '/helpers/ChartHelper.php');
	ChartHelper::plot_graph($this->getChartTables());

