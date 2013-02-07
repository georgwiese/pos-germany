<h1>Reports</h1>
<div><b>Normal tables found for years:</b> <?php echo implode(", ", $this->getTableYears()); ?></div>
<div><b>Annual tables present:</b> <?php echo $this->getAnnualTablesPresent(); ?></div>
<div <?php echo (sizeof($this->getTableCountReport()) > 0) ? "style='color: red;'" : ""?>><b>Normal tables that are defined for less that maximum possible years:</b>
<?php ReportsHelper::reportYearCountViolation($this->getTableCountReport()); ?>
</div>