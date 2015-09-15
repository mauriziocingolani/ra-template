<?php
/* @var $this CompaniesController */
/* @var $company Company */
/* @var $model CompanyPhone */
/* @var $form CActiveForm */
$this->
        addBreadcrumb('Aziende', '/aziende')->
        addBreadcrumb("Azienda {$company->CompanyName}", "/azienda/{$company->CompanyID}")->
        addBreadcrumb($model->isNewRecord ? 'Nuovo telefono' : 'Modifica telefono');
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo telefono per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php else : ?>
        Modifica telefono per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php endif; ?>
</h1>

<?php $this->widget('widgets.FlashWidget'); ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'companyphone-form',
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
        <?php echo $form->labelEx($model, 'PhoneNumber'); ?>
        <?php echo $form->textField($model, 'PhoneNumber', array('size' => 25)); ?>
        <?php echo $form->error($model, 'PhoneNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'PhoneType'); ?>
        <?php echo Html::enumDropDownList($model, 'PhoneType'); ?>
        <?php echo $form->error($model, 'PhoneType'); ?>
    </div>

    <div class="row buttons">
        <?php echo Html::button($model->isNewRecord ? 'Crea' : 'Aggiorna', array('onclick' => "$('#companyphone-form').submit();")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->