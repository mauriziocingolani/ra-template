<?php
/* @var $this UtilityController */
$this->pageTitle = 'Pulizia cache';
$this->
        addBreadcrumb('Utility')->
        addBreadcrumb($this->pageTitle);
?>

<h1>Pulizia Cache</h1>



<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

<?php elseif (Yii::app()->user->hasFlash('error')) : ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>

<?php endif; ?>