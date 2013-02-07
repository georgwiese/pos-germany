<?php
	// No direct access
	defined('_JEXEC') or die;

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 7.6.2012
	 * Time: 8:50
	 * To change this template use File | Settings | File Templates.
	 */
	class SummaryTable {

		private $labels;
		private $data;
		private $percentChar;
		private $round;
		private $yAxisName;
		private $chartName;

		public function setPercentChar($percentualValuePresent) {
			$this->percentChar = $percentualValuePresent;
		}

		public function getPercentChar() {
			return $this->percentChar;
		}

		public function setLabels($xAxisData) {
			$this->labels = $xAxisData;
		}

		public function getLabels() {
			return $this->labels;
		}

		public function setData($yAxisData) {
			$this->data = $yAxisData;
		}

		public function getData() {
			return $this->data;
		}

		public function setRound($yAxisRounding) {
			$this->round = $yAxisRounding;
		}

		public function getRound() {
			return $this->round;
		}

		public function setYAxisName($yAxisName) {
			$this->yAxisName = $yAxisName;
		}

		public function getYAxisName() {
			return $this->yAxisName;
		}

		public function addValue($value) {
			if ($this->data == null) {
				$this->data = array();
			}
			array_push($this->data, $value);
		}

		public function addLabel($value) {
			if ($this->labels == null) {
				$this->labels = array();
			}
			array_push($this->labels, $value);
		}

		public function setChartName($chartName) {
			$this->chartName = $chartName;
		}

		public function getChartName() {
			return $this->chartName;
		}


	}
