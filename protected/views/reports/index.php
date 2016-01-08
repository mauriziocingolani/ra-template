<?php
/* @var $this ReportsController */
$this->pageTitle = 'Reports';
$this->addBreadcrumb($this->pageTitle);
?>

<h1>Reports</h1>

<ul>
    <li><?php echo Html::link('Report campagne', array('/reports/report-campagne')); ?></li> 
</ul>