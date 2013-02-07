<h1>Select Excel file to import.</h1>
<form method='POST'
      action='<?php echo JRoute::_('index.php?option=com_posshop&view=import&task=import.submit'); ?>'
      enctype='multipart/form-data' name="Import">
    <p><input type=file name='data_file' accept='xls'/></p>
	<p>Use second language: <input type="checkbox" name="use_second" value="true"/> </p>
    <p><input type=submit value='upload'/></p>
	<br/>
	<p style="color: #ff0000;"><b>Note: Shop items are expected to be on excel sheet name 'Current'.</b></p>
</form><br/>
