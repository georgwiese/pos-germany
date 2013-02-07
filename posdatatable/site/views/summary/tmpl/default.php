<?php

	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require_once(JPATH_COMPONENT . '/helpers/MenuHelper.php');
	require_once(JPATH_COMPONENT . '/helpers/TableRenderer.php');
	require_once(JPATH_COMPONENT . '/helpers/NavigationHelper.php');

?>
<div id="submenu">
	<?php MenuHelper::printYearMenu(JFactory::getApplication()->getMenu(), $this->getYear());    ?>
</div>
<div id="main-tables">
	<div class="quadrants">
		<div class="quadrant">
			<div class="padding-10">
				<?php include("quadrant1.php"); ?>
			</div>
		</div>
		<div class="quadrant">
			<div class="padding-10">
				<?php include("quadrant2.php"); ?>
			</div>
		</div>
		<div class="cb">&nbsp;</div>
	</div>
	<div class="quadrants">
		<div class="quadrant">
			<div class="padding-10">
				<?php include("quadrant3.php"); ?>
			</div>
		</div>
		<div class="quadrant">
			<div class="padding-10">
				<?php include("quadrant4.php"); ?>
			</div>
		</div>
		<div class="cb">&nbsp;</div>
	</div>
</div>


