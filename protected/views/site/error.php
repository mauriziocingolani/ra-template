<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = 'ERRORE';
$this->crumbs = array(
    $this->pageTitle,
);
?>

<h2>Errore <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>