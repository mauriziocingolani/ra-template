<?php
/* @var $campaignCompany CampaignCompany */
?>

<div class="form">

    <?php $this->widget('widgets.FlashWidget', array('prefix' => 'campaigncompany')); ?>

    <?php if (count($campaigns) > 0) : ?>

        <?php
        $form2 = $this->beginWidget('CActiveForm', array(
            'id' => 'campaignform-form',
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="row">
            <?php echo $form2->dropDownList($campaignCompany, 'CampaignID', Html::listData($campaigns, 'CampaignID', 'Name'), array('empty' => '--- Seleziona la campagna ---')); ?>
            <?php echo $form2->error($campaignCompany, 'CampaignID'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Assegna alla campagna'); ?>
        </div>

        <?php $this->endWidget(); ?>

    <?php endif; ?>

</div>