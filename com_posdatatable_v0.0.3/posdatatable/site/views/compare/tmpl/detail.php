<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	include("graphlink.php");
	SummaryTableRenderer::printTables($this->getSummaryTables());
	$itemLink = NavigationHelper::routeTableView($this->getItem(), "&year=" . $this->getYear());
	echo "<a style='float:right;' href='" . $itemLink . "' class='button'>" . JText::_("COM_POSDATATABLE_BACK") . "</a>";
