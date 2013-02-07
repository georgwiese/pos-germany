<?php

// no direct access
	defined('_JEXEC') or die;
?>
<div id="right-column">
    <div class="daily-number">

		<?php foreach ($list as $item) : ?>
		<?php
		require JModuleHelper::getLayoutPath('mod_posdailynumber', '_item');?>
		<?php endforeach; ?>
    </div>
</div>
