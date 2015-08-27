<?php
/* @var $this CompaniesController */
/* @var $company Company */
/* @var $activity Activity */
/* @var $form CActiveForm */
/* @var $campaignid */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'activity-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php $this->widget('widgets.FlashWidget', array('prefix' => 'activity')); ?>

    <input name="Activity[CampaignID]" type="hidden" value="<?= $campaignid; ?>"/>

    <div class="row">
        <?php echo $form->labelEx($activity, 'ContactID'); ?>
        <?php echo $form->dropDownList($activity, 'ContactID', Html::listData($company->Contacts, 'ContactID', 'completeName'), array('empty' => '--- Seleziona un referente ---')); ?>
        <?php echo $form->error($activity, 'ContactID'); ?>
    </div>

    <hr />

    <div class="row">
        <?php echo $form->labelEx($activity, 'ActivityTypeID'); ?>
        <?php echo $form->dropDownList($activity, 'ActivityTypeID', Html::listData(ActivityType::GetAll(), 'ActivityTypeID', 'Description')); ?>
        <?php echo $form->error($activity, 'ActivityTypeID'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($activity, 'RecallDateTime'); ?>
        <?php
        $this->widget('ext.jui.EJuiDateTimePicker', array(
            'model' => $activity,
            'attribute' => 'RecallDateTime',
            'language' => 'it',
            'options' => array(
                'controlType' => 'select',
                'dateFormat' => 'yy-mm-dd',
                'showTime' => false,
                'hourMin' => 8,
                'hourMax' => 19,
                'stepMinute' => 5,
//                'timeFormat' => '', //'hh:mm tt' default
            ),
        ));
        ?> 
        <?php echo $form->error($activity, 'RecallDateTime'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($activity, 'RecallPrioritary'); ?>
        <?php echo $form->checkBox($activity, 'RecallPrioritary'); ?>
        <?php echo $form->error($activity, 'RecallPrioritary'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($activity, 'Notes'); ?>
        <?php echo $form->textArea($activity, 'Notes', array('style' => 'width: 200px;', 'rows' => 5)); ?>
        <?php echo $form->error($activity, 'Notes'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Registra'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>