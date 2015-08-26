<?php
/* @var $this CampaignsController */
/* @var $model Campaign */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'campaign-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><span class="required">*</span> campi obbligatori.</p>

    <?php echo $form->errorSummary($model, '<p>Errori di compilazione:</p>'); ?>

    <?php $this->widget('widgets.FlashWidget'); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'Name'); ?>
        <?php echo $form->textField($model, 'Name', array('size' => 25)); ?>
        <?php echo $form->error($model, 'Name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'ScriptTable'); ?>
        <?php echo $form->dropDownList($model, 'ScriptTable', Campaign::GetScripts()); ?>
        <?php echo $form->error($model, 'ScriptTable'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Pin'); ?>
        <?php echo $form->textField($model, 'Pin', array('size' => 5)); ?>
        <?php echo $form->error($model, 'Pin'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'StartDate'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'it',
            'model' => $model,
            'attribute' => 'StartDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeYear' => true,
                'changeMonth' => true,
            ),
        ));
        ?> 
        <?php echo $form->error($model, 'StartDate'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'EndDate'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'it',
            'model' => $model,
            'attribute' => 'EndDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeYear' => true,
                'changeMonth' => true,
            ),
        ));
        ?> 
        <?php echo $form->error($model, 'EndDate'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Notes'); ?>
        <?php echo $form->textArea($model, 'Notes', array('style' => 'width: 200px;', 'rows' => 5)); ?>
        <?php echo $form->error($model, 'Notes'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->