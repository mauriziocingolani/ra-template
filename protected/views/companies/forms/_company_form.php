<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'company-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><span class="required">*</span> campi obbligatori.</p>

    <?= $form->errorSummary($model, '<p>Errori di compilazione:</p>'); ?>

    <?php $this->widget('widgets.FlashWidget'); ?>

    <div class="row">
        <?= $form->labelEx($model, 'CompanyName'); ?>
        <?= $form->textField($model, 'CompanyName', array('size' => 50)); ?>
        <?= $form->error($model, 'CompanyName'); ?>
    </div>
    <div class="row">
        <?= $form->labelEx($model, 'CompanyLegalName'); ?>
        <?= $form->textField($model, 'CompanyLegalName', array('size' => 50)); ?>
        <?= $form->error($model, 'CompanyLegalName'); ?>
    </div>
    <div class="row">
        <?= $form->labelEx($model, 'CompanyGroup'); ?>
        <?= $form->textField($model, 'CompanyGroup', array('size' => 50)); ?>
        <?= $form->error($model, 'CompanyGroup'); ?>
    </div>
    <div class="row">
        <?= $form->labelEx($model, 'CompanyCode'); ?>
        <?= $form->textField($model, 'CompanyCode'); ?>
        <?= $form->error($model, 'CompanyCode'); ?>
    </div>
    <div class="row">
        <?= $form->labelEx($model, 'Notes'); ?>
        <?= $form->textArea($model, 'Notes', array('style' => 'width: 300px;', 'rows' => 5)); ?>
        <?= $form->error($model, 'Notes'); ?>
    </div>

    <div class="row buttons">
        <?= CHtml::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->