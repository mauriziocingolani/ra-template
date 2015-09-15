<?php
/* @var $this ReportsController */
$this->pageTitle = 'Report campagne';
$this->
        addBreadcrumb('Reports', '/reports')->
        addBreadcrumb($this->pageTitle);
?>

<h1>Report campagne</h1>

<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

    <a href="/reports/report-campagne">Nuova esportazione</a>

<?php else : ?>

    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'report-form',
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php echo $form->errorSummary($model, '<p>Errori di compilazione:</p>'); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'campaignid'); ?>
            <?php echo $form->dropDownList($model, 'campaignid', Html::listData($campaigns, 'CampaignID', 'Name'), array('multiple' => false)); ?>
            <?php echo $form->error($model, 'campaignid'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'startdate'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'language' => 'it',
                'model' => $model,
                'attribute' => 'startdate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'changeYear' => true,
                    'changeMonth' => true,
                ),
            ));
            ?> 
            <?php echo $form->error($model, 'startdate'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'enddate'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'language' => 'it',
                'model' => $model,
                'attribute' => 'enddate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'changeYear' => true,
                    'changeMonth' => true,
                ),
            ));
            ?> 
            <?php echo $form->error($model, 'enddate'); ?>
        </div>

        <div class="form buttons">
            <?php echo CHtml::submitButton('Esporta'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

<?php endif; ?>
