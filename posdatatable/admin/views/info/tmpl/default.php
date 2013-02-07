<?php require_once(JPATH_COMPONENT_SITE . '/helpers/TableRenderer.php'); ?>
<h1>Table information</h1>
<form id="tableInfo" method='GET'
	  action='<?php echo JRoute::_('index.php'); ?>'>
	<input type="hidden" name="view" value="info"/>
	<input type="hidden" name="option" value="com_posdatatable"/>
	<label for="table">Select table:</label>
	<select name="tableWithYear" id="table" onchange="return tableInfo.submit();">
		<?php
		foreach ($this->getTableNames() as $tableName) {
			echo "<option".(($this->getTableInfo()->name == $tableName->name)
				&& ($this->getTableInfo()->year == $tableName->year) ? " SELECTED" : "")." value='". $tableName->name . "|".$tableName->year."'>" . $tableName->name . " ".$tableName->year. "</option>";
		}
		?>
	</select>
</form>
	<h2>Table preview:</h2>
<?php TableRenderer::render($this->getTableInfo(), $this->getTableData(), $this->getYear(), 555, 0, ""); ?>
