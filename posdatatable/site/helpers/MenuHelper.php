<?php

	// No direct access
	defined('_JEXEC') or die;

	require_once("NavigationHelper.php");
	class MenuHelper {

		const YEAR_MENU_TYPE = "year-menu";

		public static function printTableMenu(JMenu $menu, $selectedYear, $selectedItemAlias) {
			$selectedItem = $menu->getItems("alias", $selectedItemAlias);
			$menuItems = $menu->getItems('menutype', $selectedItem[0]->menutype);

			$currentLevel = 1;
			$menuItemCount = sizeof($menuItems);
			$levelToSkip = null;
			for ($i = 0; $i < $menuItemCount; $i++) {
				$menuItem = $menuItems[$i];
				$nextMenuItem = ($i + 1) < $menuItemCount ? $menuItems[$i + 1] : null;

				if ($menuItem->level > $currentLevel) {
					echo "<ul class='inner-menu'>";
					$currentLevel = $menuItem->level;
				} else if ($menuItem->level < $currentLevel) {
					echo "</ul>";
					$currentLevel = $menuItem->level;
				}

				$class = htmlspecialchars($menuItem->params->get('menu-anchor_css', ''));
				$linkClass = "";

				if ($selectedItemAlias == $menuItem->alias) {
					$linkClass = "class='selected'";
				}
				if (isset($class)) {
					$class = "class='" . $class . "'";
				}
				$menuItemAlias = $menuItem->alias;
				if (isset($nextMenuItem) && ($nextMenuItem->level > $menuItem->level)) {
					$menuItemAlias = $nextMenuItem->alias;
					$levelToSkip = null;
					if (self::submenuContainsSelectedLink($menuItems, $i + 1, $selectedItemAlias)) {
						$linkClass = "class='link-expanded'";
					} else {
						$linkClass = "class='link-collapsed'";
						$levelToSkip = $nextMenuItem->level;
					}
				}

				if (self::isFirstMenuItem($i)) {
					$itemLink = NavigationHelper::routeSummaryView($selectedYear);
				} else {
					$itemLink = NavigationHelper::routeTableView($menuItemAlias, $selectedYear);
				}


				if (isset($levelToSkip) && ($menuItem->level == $levelToSkip)) {
				} else {
					echo "<li $class><a href='" . $itemLink . "' $linkClass>" . $menuItem->title . "</a></li>";
				}

			}

			while ($currentLevel > 1) {
				echo "</ul>";
				$currentLevel--;
			}
		}

		public static function isFirstMenuItem($i) {
			return $i == 0;
		}

		public static function submenuContainsSelectedLink($menuItems, $startIndex, $selectedItem) {
			$i = $startIndex;
			$menuItemCount = sizeof($menuItems);
			$previousLevel = $menuItems[$i]->level;
			while (($menuItemCount > ($i + 1)) && ($previousLevel == $menuItems[$i + 1]->level)) {
				if ($menuItems[$i]->alias == $selectedItem) {
					return true;
				}
				$i++;
				$previousLevel = $menuItems[$i]->level;
			}
			return $menuItems[$i]->alias == $selectedItem;
		}

		public static function printYearMenu(JMenu $menu, $selectedYear, $selectedItem = null, $table = null, $row = null) {
			$menuItems = $menu->getItems('menutype', self::YEAR_MENU_TYPE);
			echo "<ul id='main-tables-years'>";
			foreach ($menuItems as $menuItem) {
				if (isset($selectedItem)) {
					if (isset($row) && isset($table)) {
						$itemLink = NavigationHelper::routeCompareView($selectedItem, $menuItem->title, $table, $row);
					} else {
						$itemLink = NavigationHelper::routeTableView($selectedItem, $menuItem->title);
					}
				} else {
					$itemLink = NavigationHelper::routeSummaryView($menuItem->title);
				}

				echo "<li><a href='" . $itemLink . "'";
				echo ($menuItem->title != $selectedYear) ? "" : "class='selected'";
				echo ">$menuItem->title</a></li>";
			}
			echo "<div class='cb'>&nbsp;</div>";
			echo "</ul>";
		}

		public static function findFirstDisplayableItem($menuType) {
			$menuItems = JFactory::getApplication()->getMenu()->getItems('menutype', $menuType);
			$index = 0;
			$menuItemCount = sizeof($menuItems);
			while (($index < $menuItemCount) && (($menuItems[$index]->type != "component") || ($menuItems[$index]->component != "com_posdatatable"))) {
				$index ++;
			}
			return (($menuItems[$index]->component == "com_posdatatable") && ($menuItems[$index]->type == "component")) ? $menuItems[$index]->alias : "NOT FOUND";
		}

		public static function getQuadrant($currentItemAlias) {
			$selectedItem = JFactory::getApplication()->getMenu()->getItems("alias", $currentItemAlias);
			return substr($selectedItem[0]->menutype, strlen("quadrant"));
		}
	}