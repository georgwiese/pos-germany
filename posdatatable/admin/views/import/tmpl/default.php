<?php

	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

?>

<h1>Select Excel file to import.</h1>
<form method='POST'
      action='<?php echo JRoute::_('index.php?option=com_posdatatable&view=import&task=import.submit'); ?>'
      enctype='multipart/form-data' name="Import">
    <p><input type='file' name='data_file' accept='xls'/></p>

    <p><input type='submit' value='upload'/></p>
</form><br/>
<p><a href='<?php echo JRoute::_('index.php?option=com_posdatatable&view=import&task=import.reset'); ?>'>Reset
    database</a></p>
<br/>
