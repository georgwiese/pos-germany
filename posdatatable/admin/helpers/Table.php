<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 10.2.2012
	 * Time: 23:39
	 * To change this template use File | Settings | File Templates.
	 */
	class Table {

		private $name;
		private $year;
		private $x1Axis;
		private $x2Axis;
		private $round;
		private $annualChangeValue;
		private $annualChangeColumn;
		private $annualChangeComputationColumn;
		private $mirror;
		private $foldingColumn;
		private $enabledColumns;
		private $tableRows;
		private $id;

		function __construct() {
			$this->round = array();
			$this->enabledColumns = array();
			$this->tableRows = array();
		}


		public function setName($name) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		public function setRounding($column, $roundValue) {
			$this->round[$column] = $roundValue;
		}

		public function getRound() {
			return $this->round;
		}

		public function setX1Axis($x1Axis) {
			$this->x1Axis = $x1Axis;
		}

		public function getX1Axis() {
			return $this->x1Axis;
		}

		public function getX1AxisColumnIndex() {
			return $this->x1Axis != null ? $this->enabledColumns[$this->x1Axis] : 0;
		}

		public function setX2Axis($x2Axis) {
			$this->x2Axis = $x2Axis;
		}

		public function getX2Axis() {
			return $this->x2Axis;
		}

		public function getX2AxisColumnIndex() {
			return $this->x2Axis != null ? $this->enabledColumns[$this->x2Axis] : 0;
		}

		public function setYear($year) {
			$this->year = $year;
		}

		public function getYear() {
			return $this->year;
		}

		public function getMirror() {
			return $this->mirror;
		}

		public function setMirror($mirror) {
			$this->mirror = $mirror;
		}

		public function setAnnualChangeColumn($annualChangeColumn) {
			$this->annualChangeColumn = $annualChangeColumn;
		}

		public function getAnnualChangeColumn() {
			return $this->annualChangeColumn;
		}

		public function getAnnualChangeColumnIndex() {
			return $this->annualChangeColumn != null ? $this->enabledColumns[$this->annualChangeColumn] : 0;
		}

		public function setAnnualChangeComputationColumn($annualChangeComputationColumn) {
			$this->annualChangeComputationColumn = $annualChangeComputationColumn;
		}

		public function getAnnualChangeComputationColumn() {
			return $this->annualChangeComputationColumn;
		}

		public function setAnnualChangeValue($annualChangeValue) {
			$this->annualChangeValue = $annualChangeValue;
		}

		public function getAnnualChangeValue() {
			return $this->annualChangeValue;
		}

		public function  enableColumn($column) {
			$this->enabledColumns[$column] = $this->enabledColumnCount();
		}

		public function enabledColumnCount() {
			return count($this->enabledColumns);
		}

		public function isColumnEnabled($column) {
			return array_key_exists($column, $this->enabledColumns);
		}

		public function getRow($rowNum) {
			return $this->tableRows[$rowNum];
		}

		public function existsRow($rowNum) {
			return array_key_exists($rowNum, $this->tableRows);
		}

		public function addRow($rowNum) {
			$this->tableRows[$rowNum] = new TableRow();
		}

		function __toString() {
			return "\n\t\t\t".$this->name . " [" . $this->enabledColumnCount() . " x " . count($this->tableRows) . "]";
			//return $this->toStringWithDebugLevel();
		}

		private function toStringWithDebugLevel() {
			$message = "Table";
			$message .= "\n\tname: " . $this->name;
			$message .= "\n\tyear: " . $this->year;
			$message .= "\n\tannualChangeColumn: " . $this->annualChangeColumn;
			$message .= "\n\tannualChangeComputationColumn: " . $this->annualChangeComputationColumn;
			$message .= "\n\tannualChangeValue: " . $this->annualChangeValue;
			$message .= "\n\tenabledColumns: |";

			foreach (array_keys($this->enabledColumns) as $column) {
				$message .= $column . "|";
			}

			$message .= "\n\tmirror: " . $this->mirror;
			$message .= "\n\tround: " . $this->round;
			$message .= "\n\tx1Axis: " . $this->x1Axis;
			$message .= "\n\tx2Axis: " . $this->x2Axis;
			$message .= "\n\tfoldingColumn: " . $this->foldingColumn;
			$message .= "\n\ttableRows: ";
			$message .= "\n";

			foreach ($this->tableRows as $row) {
				$message .=  "\n\t\t".$row;
			}
			return $message;
		}

		public function setFoldingColumn($foldingColumn) {
			$this->foldingColumn = $foldingColumn;
		}

		public function getFoldingColumn() {
			return $this->foldingColumn;
		}

		public function getEnabledColumns() {
			return array_keys($this->enabledColumns);
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getRows() {
			return $this->tableRows;
		}

		public function getId() {
			return $this->id;
		}


	}
