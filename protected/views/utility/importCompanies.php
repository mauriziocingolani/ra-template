<?php
/* @var $this UtilityController */
/* @var $model UtilityLoadXlsForm */
/* @var $campaigns Campaign[] */
$this->pageTitle = 'Importazione agenzie';
$this->
        addBreadcrumb('Utility')->
        addBreadcrumb($this->pageTitle);
?>

<h1>Importazione agenzie</h1>

<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

    <a href="/utility/importazione-agenzie">Importa un altro file</a>

<?php else : ?>

    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <?php echo $form->errorSummary($model, '<p>Errori di compilazione:</p>'); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'campaignid'); ?>
            <?php echo $form->dropDownList($model, 'campaignid', Html::listData($campaigns, 'CampaignID', 'Name')); ?>
            <?php echo $form->error($model, 'campaignid'); ?>
        </div>

        <div class="row">
            <?php echo $form->fileField($model, 'file'); ?>
            <?php echo $form->error($model, 'file'); ?>
        </div>

        <div class="form buttons">
            <?php echo CHtml::submitButton('Carica'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

<?php endif; ?>
