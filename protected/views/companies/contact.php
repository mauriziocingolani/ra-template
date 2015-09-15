<?php
/* @var $this CompaniesController */
/* @var $company Company */
/* @var $model CompanyContact */
/* @var $form CActiveForm */
$this->
        addBreadcrumb('Aziende', '/aziende')->
        addBreadcrumb("Azienda {$company->CompanyName}", "/azienda/{$company->CompanyID}")->
        addBreadcrumb($model->isNewRecord ? 'Nuovo contatto' : 'Modifica contatto');
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo contatto per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php else : ?>
        Modifica contatto per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php endif; ?>
</h1>

<?php $this->widget('widgets.FlashWidget'); ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'companycontact-form',
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
        <?php echo $form->labelEx($model, 'FirstName'); ?>
        <?php echo $form->textField($model, 'FirstName', array('size' => 25)); ?>
        <?php echo $form->error($model, 'FirstName'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'LastName'); ?>
        <?php echo $form->textField($model, 'LastName', array('size' => 25)); ?>
        <?php echo $form->error($model, 'LastName'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Role'); ?>
        <?php echo $form->textField($model, 'Role', array('size' => 25)); ?>
        <?php echo $form->error($model, 'Role'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Phone'); ?>
        <?php echo $form->textField($model, 'Phone', array('size' => 25)); ?>
        <?php echo $form->error($model, 'Phone'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Email'); ?>
        <?php echo $form->textField($model, 'Email', array('size' => 25)); ?>
        <?php echo $form->error($model, 'Email'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Notes'); ?>
        <?php echo $form->textArea($model, 'Notes', array('style' => 'width: 300px;', 'rows' => 5)); ?>
        <?php echo $form->error($model, 'Notes'); ?>
    </div>

    <div class="row buttons">
        <?php echo Html::button($model->isNewRecord ? 'Crea' : 'Aggiorna', array('onclick' => "$('#companycontact-form').submit();")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>