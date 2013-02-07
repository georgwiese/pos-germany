<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 2.10.2012
	 * Time: 19:14
	 * To change this template use File | Settings | File Templates.
	 */
	defined('_JEXEC') or die;
	foreach ($this->items as $i => $article) {
		echo "<tr class='main' onMouseOver=\"this.style.cursor='pointer'\" onClick=\"parent.location='".JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid))."'\">";
		echo "<td style='vertical-align:middle;text-align:left;'><h2>" . $article->title . "</h2><div style='color:black;'>" . ((isset($showImages) && $showImages) ? $article->introtext : preg_replace('/<img[^>]*>/', '', $article->introtext)) . "</div></td>";
		echo "</tr>";
	}
