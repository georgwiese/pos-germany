<?php

	// No direct access
	defined('_JEXEC') or die;

	require_once("pchart/pChart/pData.php");
	require_once("pchart/pChart/pChart.php");

	define("font", "FreeMono.ttf");

	class ChartHelper {


		static function plot_graph($summaryTables) {

			$secondYAxisEnabled = sizeof($summaryTables) == 2;
			$graph = self::createGraph();
			$dataSet = self::createDataSet($summaryTables[0], "Serie1");

			if (!isset($yAxisName)) {
				$yAxisName = JText::_('COM_POSDATATABLE_DEFAULT_YAXIS');
			}

			$dataSet->SetYAxisName($yAxisName);
			$graph->drawScale($dataSet->GetData(), $dataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, 0, 1);

			$graph->drawGraphArea(255, 255, 255, TRUE);
			self::drawOneSerie($graph, $dataSet);

			// Clear the scale
			$graph->clearScale();

			if ($secondYAxisEnabled) {
				$dataSet->RemoveSerie("Serie1");
				$dataSet = self::createDataSet($summaryTables[1], "Serie2", $dataSet);
				$graph->drawRightScale($dataSet->GetData(), $dataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, 0, 0);
				self::drawOneSerie($graph, $dataSet);
			}

			// Write the legend (box less)
			$graph->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			$graph->drawLegend(0, 230, $dataSet->GetDataDescription(), 255, 255, 255);

			// Write the title
			self::writeChartTitle($summaryTables[0]->getChartName(), $graph);
			$graph->clearShadow();

			// Render the picture
			//	print_r($DataSet->GetData());
			//	$Graph->reportWarnings();
			$graph->Stroke();
		}

		public static function drawOneSerie(pChart $graph, pData $dataSet) {
			$graph->drawGrid(4, TRUE, 230, 230, 230, 10);
			$graph->setShadowProperties(3, 3, 0, 0, 0, 30, 4);
			$graph->SetLineStyle(1);
			$graph->drawLineGraph($dataSet->GetData(), $dataSet->GetDataDescription());
			$graph->clearShadow();
			$graph->SetLineStyle(1);
			$graph->drawPlotGraph($dataSet->GetData(), $dataSet->GetDataDescription(), 3, 2, 255, 255, 255);
		}

		public static function createDataSet(SummaryTable $summaryTable, $seriesName, pData $dataSet = null) {
			if ($dataSet == null) {
				$dataSet = new pData;
				$dataSet->AddPoint($summaryTable->getLabels(), "Serie3");
				$dataSet->SetAbsciseLabelSerie("Serie3");
			}
			$dataSet->AddPoint($summaryTable->getData(), $seriesName);
			$dataSet->AddSerie($seriesName);
			$dataSet->SetSerieName($summaryTable->getYAxisName(), $seriesName);
			return $dataSet;
		}

		public static function createGraph() {
			// Initialise the graph
			$chart = new pChart(760, 280);

			// Prepare the graph area
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			$chart->setGraphArea(70, 40, 715, 190);

			// Initialise graph area
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			return $chart;
		}

		public static function writeChartTitle($chartName, pChart $chart) {
			$fontSize = strlen($chartName) > 15 ? 14 : 18;
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, $fontSize);
			$chart->drawTitle(0, 0, $chartName, 0, 0, 0, 760, 30);
		}

	}