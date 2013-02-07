<?php

	// No direct access
	defined('_JEXEC') or die;

	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 8.6.2012
	 * Time: 8:49
	 * To change this template use File | Settings | File Templates.
	 */
	class NavigationHelper {

		public static function routeTableView($item, $year) {
			return JRoute::_("index.php?option=com_posdatatable&view=table&item=" . $item . "&year=" . $year);
		}

		public static function routeChartView($item, $year, $table, $row) {
			return JRoute::_("index.php?option=com_posdatatable&view=chart&table=" . $table . "&row=" . $row . "&year="
				. $year . "&item=" . $item . "&format=raw");
		}

		public static function routeCompareView($item, $year, $table, $row) {
			return JRoute::_("index.php?option=com_posdatatable&view=compare&table=" . $table . "&row=" . $row . "&year="
				. $year . "&item=" . $item);
		}

		public static function routeSummaryView($year) {
			return JRoute::_("index.php?option=com_posdatatable&year=" . $year);
		}

	}
