
<?php

	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	JHTML::_('behavior.tooltip');

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 24.2.2012
	 * Time: 22:18
	 * To change this template use File | Settings | File Templates.
	 */
	class ShopRenderer {

		private $table;

		public function render(ShopDao $shopDao) {
			$this->startPage();
			$table = $shopDao->loadShopItems();
			$config = $shopDao->loadTableConfig();
			$sliders = array();
			$previousTableIndex = 0;
			foreach ($table as $row) {
				$tableIndex = $row->table_id;
				$rowIndex = $row->row_id;
				$data = explode("|", $row->row_data);
				if ($rowIndex == 0) {
					if ($tableIndex > 1) {
						$this->endTable($previousTableIndex);
					}
					$this->startTable($config[$tableIndex]->picture, $data);
				} else {
					$this->renderRow($data, $tableIndex, $rowIndex, $sliders);
				}
				$previousTableIndex = $tableIndex;
			}
			if (sizeof($table) >0) $this->endTable($previousTableIndex);
			$this->endPage($sliders, sizeof($table) > 0);
		}

		private function startTable($tableImage, $tableHeader) {
			require("shop_table_header.php");
		}

		private function renderRow($data, $tableIndex, $rowIndex, &$sliders) {
			require("shop_table_row.php");
		}

		private function endTable($tableIndex) {
			require("shop_table_footer.php");
		}

		private function startPage() {
			require("shop_page_header.php");
		}

		private function endPage(&$sliders, $submitEnabled) {
			require("shop_page_footer.php");
		}

	}
