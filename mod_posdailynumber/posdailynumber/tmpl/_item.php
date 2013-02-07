<?php

	// no direct access
	defined('_JEXEC') or die;
	require_once JPATH_SITE . '/components/com_content/helpers/route.php';
?>
<h2>Daily Number</h2>
<div class="padding-10" style="padding-top: 0px">
    <h3><?php echo $item->title; ?></h3>

	<?php
	if (!$params->get('intro_only')) {
		echo $item->afterDisplayTitle;
	}
	echo $item->beforeDisplayContent;

	echo $item->introtext;
	echo $item->fulltext;
	?>

    <div style="text-align: center;"><a
            href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($params->get('catid')));?>"
            style="text-decoration:none"><img style="margin-bottom:0px;border:0px"
                                              src="<?php echo JURI::root(true) . '/media/mod_posdailynumber/images/pointer.gif';?>"/><?php echo JText::_("MOD_POSDAILYNUMBER_ARCHIVE"); ?>
    </a>
    </div>
</div>
<hr size="1" color="#cccccc"><br><center>

