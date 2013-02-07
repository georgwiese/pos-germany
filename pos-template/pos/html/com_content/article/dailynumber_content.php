<?php
	/**
	 * @package        Joomla.Site
	 * @subpackage    com_content
	 * @copyright    Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
	 * @license        GNU General Public License version 2 or later; see LICENSE.txt
	 */

// no direct access
	defined('_JEXEC') or die;

	JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
	$params = $this->item->params;
	$images = json_decode($this->item->images);
	$urls = json_decode($this->item->urls);
	$user = JFactory::getUser();


?>

<br>

<div style="text-align: center;">
	<?php
	if ($this->item->prev != "") {
		echo "<a href='" . $this->item->prev . "' class='button'>&lt; ".JText::_("TPL_POS_PREVIOUS_NOD")."</a> ";
	}
	$title = $this->escape($this->item->category_title);
	echo "<a href='" . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)) . "' class='button'>" . $title . "</a> ";

	if ($this->item->next != "") {
		echo "<a href='" . $this->item->next . "' class='button'>".JText::_("TPL_POS_NEXT_NOD")." &gt;</a>";
	}
	?>
</div>
<br>

<center>
    <div style="width:400px;text-align:left;">
        <h3><?php echo $this->escape($this->item->title); ?></h3>

		<?php  if (!$params->get('show_intro')) :
		echo $this->item->event->afterDisplayTitle;
	endif; ?>

		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php if (isset ($this->item->toc)) : ?>
		<?php echo $this->item->toc; ?>
		<?php endif; ?>

		<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position == '0')) OR  ($params->get('urls_position') == '0' AND empty($urls->urls_position)))
		OR (empty($urls->urls_position) AND (!$params->get('urls_position')))
	): ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>

		<?php if ($params->get('access-view')): ?>
		<?php if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
			<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
            <div class="img-fulltext-<?php echo htmlspecialchars($imgfloat); ?>">
                <img
					<?php if ($images->image_fulltext_caption):
					echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"';
				endif; ?>
                        src="<?php echo htmlspecialchars($images->image_fulltext); ?>"
                        alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
            </div>
			<?php endif; ?>
		<?php echo $this->item->text; ?>
		<?php endif; ?>
    </div>
</center>

<?php echo $this->item->event->afterDisplayContent; ?>
