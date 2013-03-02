<?php

// No direct access.
	defined('_JEXEC') or die;

// check modules
	$showRightColumn = $this->countModules('rightcontent');
	$showSubMenu = $this->countModules('submenu');

	JHtml::_('behavior.framework', true);

// get params
	$logo = ($this->params->get('logo') != null) ? $this->params->get('logo') : $this->baseurl . '/templates/' . $this->template . '/images/bg-header.png';
	$app = JFactory::getApplication();
	$doc = JFactory::getDocument();
	$templateparams = $app->getTemplate(true)->params;

	$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/md_stylechanger.js', 'text/javascript', true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:jdoc="http://www.w3.org/1999/XSL/Transform"
      xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/common.css"
          type="text/css"/>
</head>

<body>

<div id="page-wrapper">
	<div id="page">
		<div id="header">
			<a href="<?php echo JURI::root(true)?>"><img border=0 src="<?php echo $logo;?>"/></a>
		</div> 
		<div id="mainmenu">
			<jdoc:include type="modules" name="mainmenu"/>
		</div>
		<div id="middle">
			<?php if ($showRightColumn) : ?><div id="main-column"><?php endif; ?>
            <div id="main-tables-wrapper">
                <jdoc:include type="modules" name="maincontent" />
                <jdoc:include type="message" />
                <jdoc:include type="component" />
            </div>
            <div id="footmenu">
                <jdoc:include type="modules" name="footmenu" />
                <div class="cb">&nbsp;</div>
            </div>
			<?php if ($showRightColumn) : ?></div><?php endif; ?>
			<?php if ($showRightColumn) : ?>
            <div id="right-column">
                <jdoc:include type="modules" name="rightcontent" />
            </div>
			<?php endif; ?>
            <div class="cb">&nbsp;</div>
        </div>
    </div>
</div>
</body>
<jdoc:include type="modules" name="debug" />
</body>
</html>
