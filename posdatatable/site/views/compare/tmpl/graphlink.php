<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require_once(JPATH_COMPONENT . '/helpers/NavigationHelper.php');
	$graphLink = NavigationHelper::routeChartView($this->getItem(), $this->getYear(), $this->getTableName(), $this->getRow());
?>
<img border='0' width='762px' height='282px' src='<?php echo $graphLink;?>'/>
