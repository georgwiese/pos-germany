<?php

	// No direct access
	defined('_JEXEC') or die;

	class Cell {
		private $formattedValue;
		private $controlLink;
		private $headerBegin = "";
		private $headerEnd = "";
		private $spanString = "";
		private $cellClass = "";
		private $cellTag = "td";
		private $foldingSign = "";
		private $cellStyle = "style='white-space: nowrap;'";

		function __construct($formattedValue, $controlLink) {
			$this->formattedValue = $formattedValue;
			$this->controlLink = $controlLink;
		}

		public function setCellClass($cellClass) {
			$this->cellClass = $cellClass;
		}

		public function getCellClass() {
			return $this->cellClass;
		}

		public function setCellStyle($cellStyle) {
			$this->cellStyle = $cellStyle;
		}

		public function getCellStyle() {
			return $this->cellStyle;
		}

		public function setCellTag($cellTag) {
			$this->cellTag = $cellTag;
		}

		public function getCellTag() {
			return $this->cellTag;
		}

		public function setControlLink($controlLink) {
			$this->controlLink = $controlLink;
		}

		public function getControlLink() {
			return $this->controlLink;
		}

		public function setFoldingSign($foldingSign) {
			$this->foldingSign = $foldingSign;
		}

		public function getFoldingSign() {
			return $this->foldingSign;
		}

		public function setFormattedValue($formattedValue) {
			$this->formattedValue = $formattedValue;
		}

		public function getFormattedValue() {
			return $this->formattedValue;
		}

		public function setHeaderBegin($headerBegin) {
			$this->headerBegin = $headerBegin;
		}

		public function getHeaderBegin() {
			return $this->headerBegin;
		}

		public function setHeaderEnd($headerEnd) {
			$this->headerEnd = $headerEnd;
		}

		public function getHeaderEnd() {
			return $this->headerEnd;
		}

		public function setSpanString($spanString) {
			$this->spanString = $spanString;
		}

		public function getSpanString() {
			return $this->spanString;
		}

		public function render() {
			$formattedValue = (strlen($this->getFormattedValue()) == 0) ? $formattedValue = "&nbsp;" : $this->getFormattedValue();
			return "<" . $this->cellTag . " " . $this->cellClass . " " . $this->cellStyle . " " . $this->spanString . " "
				. $this->controlLink . ">" . $this->foldingSign . $this->headerBegin . $formattedValue . $this->headerEnd . " </" . $this->cellTag . " > \n";
		}

		/** Updates span settings
		 * @param $cellSpan string with span settings
		 * @return bool true if row span was detected, else false.
		 */
		public function updateSpan($cellSpan) {
			$spanLength = strlen($cellSpan);
			$ci = 0;
			if ($spanLength > 0) {
				$type = substr($cellSpan, $ci++, 1);
				if ($type == "C") {
					$this->setSpanString($this->getSpanString() . " colspan=" . substr($cellSpan, $ci++, 1));
					if ($spanLength > 2) {
						$type = substr($cellSpan, $ci++, 1);
					}
				}
				if ($type == "R") {
					$this->setSpanString($this->getSpanString() . " rowspan=" . substr($cellSpan, $ci, 1));
					return true;
				}
			}
			return false;

		}

		public function initValueWithAnnualChange($year1Value, $year2Value, $round) {
			if (isset($year1Value) && isset($year2Value)) {
				if (($year1Value <= 0) || ($year2Value <= 0)) {
					$annualChange = JText::_('COM_POSDATATABLE_NA');
				} else {
					$annualChange = number_format((($year1Value - $year2Value) / $year2Value * 100), $round, ",", " ")
						. "%";
				}
			} else {
				$annualChange = JText::_('COM_POSDATATABLE_NA');
			}
			$this->setFormattedValue($annualChange);
		}

		public function initValueWithNumber($data, $round, $isPercentValue) {
			$this->setFormattedValue(number_format($data, $round, ",", " ").(($isPercentValue) ? "%" : ""));
		}

		public function initSubHeaderTag() {
			$this->setHeaderBegin("<h2>");
			$this->setHeaderEnd("</h2>");
		}

		public function initFoldingParentSettings($rowNumber, $tableNumber, $compactMode) {
			if (!$compactMode) {
				$this->setControlLink("onmouseover=\"this.style.cursor='pointer'\" onClick='invertChildrenVisibility(\""
					. $rowNumber . "\", $tableNumber)'");
				$this->setFoldingSign("+");
			} else {
				$this->setControlLink("");
			}
		}

		public function initCellClass($row, $previousKeepHeader) {
			$cellClass = "";
			if ($row->is_header || $previousKeepHeader) {
				if ($row->row_num > 1 && !$previousKeepHeader) {
					$cellClass = "class='sub'";
				}
			} else {
				$cellClass = "class='main'";
			}
			$this->setCellClass($cellClass);
		}

		public function initHeaderCell() {
			$this->setCellTag("th");
			$this->setCellStyle("");
			$this->setControlLink("");
		}

		public function initFoldingChild($isHeader, $columnNumber) {
			if ($isHeader) {
				$this->setControlLink("");
			}
			if ($columnNumber == 0) {
				// first column of child row
				$this->setCellClass("class='sub'");
			}

		}
	}
