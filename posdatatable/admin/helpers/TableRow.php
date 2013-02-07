<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 15.2.2012
	 * Time: 9:19
	 * To change this template use File | Settings | File Templates.
	 */
	class TableRow {

		private $rowNum;
		private $data;
		private $parentRowNum;
		private $headerRow;
		private $annualChangeValue;
		private $x1AxisValue;
		private $x2AxisValue;
		private $tableId;
		private $span;

		function __construct() {
			$this->data = array();
			$this->annualChangeValue = -1;
			$this->span = "|";
		}

		public function setAnnualChangeValue($annualChangeValue) {
			$this->annualChangeValue = $annualChangeValue;
		}

		public function getAnnualChangeValue() {
			return $this->annualChangeValue;
		}

		public function setHeaderRow($headerRow) {
			$this->headerRow = $headerRow;
		}

		public function getHeaderRow() {
			return $this->headerRow;
		}

		public function setParentRowNum($parentRowNum) {
			$this->parentRowNum = $parentRowNum;
		}

		public function getParentRowNum() {
			return $this->parentRowNum;
		}

		public function setRowNum($rowNum) {
			$this->rowNum = $rowNum;
		}

		public function getRowNum() {
			return $this->rowNum;
		}

		public function setSpan($span) {
			$this->span = $span;
		}

		public function getSpan() {
			return $this->span;
		}

		public function setTableId($tableId) {
			$this->tableId = $tableId;
		}

		public function getTableId() {
			return $this->tableId;
		}

		public function setX1AxisValue($x1AxisValue) {
			$this->x1AxisValue = $x1AxisValue;
		}

		public function getX1AxisValue() {
			return $this->x1AxisValue;
		}

		public function setX2AxisValue($x2AxisValue) {
			$this->x2AxisValue = $x2AxisValue;
		}

		public function getX2AxisValue() {
			return $this->x2AxisValue;
		}

		public function addData($value) {
			array_push($this->data, $value);
		}

		function __toString() {
			$message = "Row " . $this->rowNum . ": ";
			$message .= "\n\t\t\tannualChange: " . $this->annualChangeValue;
			$message .= "\n\t\t\theaderRow: " . $this->headerRow;
			$message .= "\n\t\t\tparentRowNum: " . $this->parentRowNum;
			$message .= "\n\t\t\tspan: " . $this->span;
			$message .= "\n\t\t\ttableId: " . $this->tableId;
			$message .= "\n\t\t\tx1AxisValue: " . $this->x1AxisValue;
			$message .= "\n\t\t\tx2AxisValue: " . $this->x2AxisValue;
			$message .= "\n\t\t\tdata: |";
			foreach ($this->data as $cell) {
				$message .=  $cell . "|";
			}
			return $message;
		}

		public function getData() {
			return $this->data;
		}

		public function addSpan($span) {
			$this->span .= $span."|";
		}


	}
