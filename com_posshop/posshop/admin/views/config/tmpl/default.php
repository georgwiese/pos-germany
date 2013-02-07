<form action="<?php echo JRoute::_('index.php?option=com_posshop&view=config&task=config.submit'); ?>" method="POST">
	<?php
	$config = $this->getConfig();
	$tableNames = $this->getTableNames();
	if (sizeof($tableNames) > 0) {
		?>
        <table>
            <tr>
                <th>Table name</th>
                <th>Color in chart</th>
                <th>Image</th>
            </tr>
			<?php
			foreach ($tableNames as $tableName) {
				if (isset($config[$tableName->table_id])) {
					$picture = $config[$tableName->table_id]->picture;
					$color = $config[$tableName->table_id]->color;
				} else {
					$picture = "";
					$color = "#715B47";
				}
				echo "<tr>";
				echo "<td>" . $tableName->name . "</td>";
				echo "<td><input name='color" . $tableName->table_id . "' class='color' value='" . $color . "'/></td>";
				$field = $this->getForm()->getField('imageurl');
				$field->setId('imageurl' . $tableName->table_id);
				$field->setValue($picture);
				echo "<td>" . $field->input . "</td>";
				echo "</tr>";
			}
			?>
        </table>
        <input type="submit" value="Save" name="Save"/>
        <a href="<?php echo JRoute::_('index.php?option=com_posshop&view=config&task=config.reset'); ?>"><?php echo JText::_("COM_POSSHOP_RESET_BUTTON");?></a>
		<?php
	} else {
		echo "<br>Upload excel with shop items first!<br>";
	} ?>
</form>
