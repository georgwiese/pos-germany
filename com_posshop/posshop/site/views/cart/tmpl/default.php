<?php
	require("ShopRenderer.php");

	$renderer = new ShopRenderer();
	$renderer->render($this->getShopDao());
?>