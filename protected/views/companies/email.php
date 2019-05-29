<?php
/* @var $this CompaniesController */
/* @var $company Company */
/* @var $model CompanyEmail */
/* @var $form CActiveForm */
$this->pageTitle = $model->isNewRecord ? 'Nuovo indirizzo email' : 'Modifica indirizzo email';
$this->
        addBreadcrumb('Aziende', array('/aziende'))->
        addBreadcrumb("Azienda {$company->CompanyName}", array("/azienda/{$company->CompanyID}"))->
        addBreadcrumb($this->pageTitle);
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo indirizzo email per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php else : ?>
        Modifica indirizzo email per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php endif; ?>
</h1>

<?php $this->widget('widgets.FlashWidget'); ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'companyemail-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><span class="required">*</span> campi obbligatori.</p>

    <?php echo $form->errorSummary($model, '<p>Errori di compilazione:</p>'); ?>

    <?php if (Yii::app()->user->hasFlash('success')) : ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'Address'); ?>
        <?php echo $form->textField($model, 'Address', array('size' => 50)); ?>
        <?php echo $form->error($model, 'Address'); ?>
    </div>

    <div class="row buttons">
        <?php echo Html::button($model->isNewRecord ? 'Crea' : 'Aggiorna', array('onclick' => "$('#companyemail-form').submit();")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->