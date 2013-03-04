<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	include(JPATH_COMPONENT . "/helpers/pchart/pChart/pData.php");
	include(JPATH_COMPONENT . "/helpers/pchart/pChart/pChart.php");

	$data = isset($_GET["data"]) ? explode("$", $_GET["data"]) : array();
	$alts = array(
		JText::_('COM_POSWHATDOYOUPAY_CHART_LEFT_OVER_FOR_YOU'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_INCOME_TAX'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_VAT'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_EXCISE_TAXES'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_HEALTHCARE_CONTRIBUTIONS'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_RETIREMENT_INSURANCE'),
		JText::_('COM_POSWHATDOYOUPAY_CHART_OTHER_CONTRIBUTIONS')
	);
	array_splice($alts, sizeof($data));

	// Dataset definition
	$DataSet = new pData;
	$DataSet->AddPoint($data, "Serie1");
	$DataSet->AddPoint($alts, "Serie2");
	$DataSet->AddAllSeries();
	$DataSet->SetAbsciseLabelSerie("Serie2");

	// Initialise the graph
	$graph = new pChart(400, 450);
	$graph->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/FreeMono.ttf", 8);

	$graph->drawFilledRoundedRectangle(7, 7, 443, 393, 5, 240, 240, 240);
	$graph->drawRoundedRectangle(5, 5, 445, 395, 5, 230, 230, 230);
	$graph->setColorPalette(0, 0, 0, 255);
	$graph->setColorPalette(3, 153, 0, 25);

	// Draw the pie chart
	$graph->setShadowProperties(2, 2, 200, 200, 200);
	$graph->drawFlatPieGraphWithShadow($DataSet->GetData(), $DataSet->GetDataDescription(), 200, 200, 150, PIE_PERCENTAGE, 15);
	$graph->drawPieLegend(150, 300, $DataSet->GetData(), $DataSet->GetDataDescription(), 250, 250, 250);

	$graph->Stroke();
?>  