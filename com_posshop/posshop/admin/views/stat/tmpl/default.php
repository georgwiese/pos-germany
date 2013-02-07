<br/>
Total people count: <?php echo $this->getTotal(); ?>
<br/><br/>
<table class="results">
    <tr>
        <th>Table item</th>
        <th>Count</th>
        <th>%</th>
        <th>Average</th>
    </tr>

	<?php
	foreach ($this->getResults() as $row) {
		echo "<tr>";
		echo "<td class='name'>" . $row->name . "</td>";
		echo "<td>" . $row->items . "</td>";
		echo "<td>".(($this->getTotal() > 0) ? round((($row->items / $this->getTotal()) * 100),2) : 0)."%</td>";
		echo "<td>" . $row->avg . "</td>";
		echo "</tr>";
	}
	?>
</table>
