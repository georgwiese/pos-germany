<?php

	// No direct access
	defined('_JEXEC') or die;

	require_once("pchart/pChart/pData.php");
	require_once("pchart/pChart/pChart.php");

	define("font", "FreeMono.ttf");

	class ChartHelper {

		static function plot_graph($table, $config, $total, $your) {

			$dataSet = new pData;
			$chart = new pChart(700, 330);

			$labels = array(JText::_("COM_POSSHOP_CURRENT_STATE_LABEL"), JText::_("COM_POSSHOP_YOUR_STATE_LABEL"));
			$dataSet->addPoint($labels, "Name");

			$previousTableIndex = 0;
			$tableName = "";
			$colors = array();
			$serieIndex = 0;
			$sum = 0;

			foreach ($table as $row) {
				$tableIndex = $row->table_id;
				$rowIndex = $row->row_id;
				$data = explode("|", $row->row_data);
				if ($rowIndex == 0) {
					if ($tableIndex > 1) {
						// vytvor stlpec
						$array1 = array($sum / 1000);
						$percentValue = round(($sum / $total) * 100, 2);
						$dataSet->AddPoint($array1, "Serie" . $previousTableIndex);
						$dataSet->SetSerieName($tableName . " " . $percentValue . "%", "Serie" . $previousTableIndex);
						$sum = 0;
					}
					$sum = 0;
					$color = self::html2rgb(trim($config[$tableIndex]->color));
					$chart->setColorPalette($tableIndex, $color[0], $color[1], $color[2]);
					array_push($colors, $color);
					$tableName = $data[0];
				} else {
					$sum += $data[4];
				}
				$previousTableIndex = $tableIndex;
			}

			$array1 = array($sum / 1000);
			$percentValue = round(($sum / $total) * 100, 2);
			$dataSet->AddPoint($array1, "Serie" . $previousTableIndex);
			$dataSet->SetSerieName($tableName . " " . $percentValue . "%", "Serie" . $previousTableIndex);

			// bar 2
			$array0 = array(null, $your);
			$dataSet->addPoint($array0, "Serie" . (++$previousTableIndex));
			$dataSet->SetSerieName(JText::_("COM_POSSHOP_YOUR_STATE_LABEL"), "Serie" . $previousTableIndex);
			$chart->setColorPalette($previousTableIndex - 1, 255, 128, 64);

			$dataSet->AddAllSeries();
			$dataSet->SetAbsciseLabelSerie();
			$dataSet->SetYAxisName(JText::_("COM_POSSHOP_Y_AXIS_TITLE"));
			// Initialise the graph
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			$chart->setGraphArea(50, 30, 350, 300);
			$chart->drawFilledRoundedRectangle(5, 5, 697, 320, 5, 240, 240, 240);
			$chart->drawRoundedRectangle(3, 3, 700, 320, 5, 230, 230, 230);
			$chart->drawGraphArea(255, 255, 255, TRUE);
			$chart->drawScale($dataSet->GetData(), $dataSet->GetDataDescription(), SCALE_ADDALL, 150, 150, 150, TRUE, 0, 2, TRUE);
			$chart->drawGrid(4, TRUE, 230, 230, 230, 50);

			// Draw the 0 line
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			$chart->drawTreshold(0, 143, 55, 72, TRUE, TRUE);


			// Draw the bar graph
			$chart->drawStackedBarGraph($dataSet->GetData(), $dataSet->GetDataDescription(), TRUE);

			// Finish the graph
			//print_r($dataSet->GetDataDescription());

			// reverse legend descriptions and colors
			$description = $dataSet->GetDataDescription();
			$legend = array_reverse($description["Description"], false);
			$value = array_shift($legend);
			array_push($legend, $value);
			$description["Description"] = $legend;
			for ($i = 0; $i < sizeof($colors); $i++) {
				$chart->setColorPalette(sizeof($colors) - $i - 2, $colors[$i][0], $colors[$i][1], $colors[$i][2]);
			}

			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 8);
			$chart->drawLegend(360, 30, $description, 255, 255, 255);
			$chart->setFontProperties(JPATH_COMPONENT . "/helpers/pchart/Fonts/".font, 14);
			$chart->drawTitle(50, 22, JText::_("COM_POSSHOP_PRICE_OF_THE_STATE_TITLE"), 50, 50, 50, 585);
			//print_r($dataSet->GetData());
			$chart->Stroke();
		}

		public static function createGraph() {
			// Initialise the graph
		}


		private static function html2rgb($color) {
			if ($color[0] == '#')
				$color = substr($color, 1);

			if (strlen($color) == 6)
				list($r, $g, $b) = array($color[0] . $color[1],
					$color[2] . $color[3],
					$color[4] . $color[5]);
			elseif (strlen($color) == 3)
				list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
			else
				return false;

			$r = hexdec($r);
			$g = hexdec($g);
			$b = hexdec($b);

			return array($r, $g, $b);
		}


	}