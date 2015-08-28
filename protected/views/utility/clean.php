<?php
/* @var $this UtilityController */
/* @var $model UtilityCleanDbForm */
$this->pageTitle = 'Pulizia db';
$this->crumbs = array(
    'Utility',
    $this->pageTitle,
);
?>

<h1>Pulizia Db</h1>

<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

<?php else : ?>

    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <p style="color: red;">
        <strong>ATTENZIONE!</strong> <br />
        Questa operazione distrugger&agrave; i dati presenti nel database
        riguardanti aziende (con relativi dati collegati) e attività. <br />Se sei sicuro di voler procedere digita
        CLEAN nel campo qui sotto e premi 'Procedi'.
    </p>

    <div class="form">
        <?php echo CHtml::beginForm(); ?>

        <div class="row">
            <?php echo CHtml::activeTextField($model, 'text') ?>
            <?php echo CHtml::error($model, 'text'); ?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Procedi'); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->

<?php endif; ?>