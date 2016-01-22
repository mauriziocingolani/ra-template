<?php
/* @var $this CompaniesController */
/* @var $company Company */
/* @var $model CompanyAddress */
/* @var $form CActiveForm */
$this->pageTitle = $model->isNewRecord ? 'Nuovo indirizzo' : 'Modifica indirizzo';
$this->
        addBreadcrumb('Aziende', array('/aziende'))->
        addBreadcrumb("Azienda {$company->CompanyName}", array("/azienda/{$company->CompanyID}"))->
        addBreadcrumb($this->pageTitle);
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo indirizzo per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php else : ?>
        Modifica indirizzo per l'azienda <u><?= Html::encode($company->CompanyName); ?></u>
    <?php endif; ?>
</h1>

<?php $this->widget('widgets.FlashWidget'); ?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'companyaddress-form',
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
        <?php echo $form->labelEx($model, 'AddressType'); ?>
        <?php echo Html::enumDropDownList($model, 'AddressType'); ?>
        <?php echo $form->error($model, 'AddressType'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Address'); ?>
        <?php echo $form->textField($model, 'Address', array('size' => 50)); ?>
        <?php echo $form->error($model, 'Address'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'City'); ?>
        <?php echo $form->textField($model, 'City', array('size' => 25)); ?>
        <?php echo $form->error($model, 'City'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'ZipCode'); ?>
        <?php echo $form->textField($model, 'ZipCode', array('size' => 10)); ?>
        <?php echo $form->error($model, 'ZipCode'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'ProvinciaID'); ?>
        <?php echo $form->dropDownList($model, 'ProvinciaID', Html::listData($province, 'ProvinciaID', 'Provincia'), array('style' => 'width: 200px;', 'empty' => '--- Seleziona la provincia ---')); ?>
        <?php echo $form->error($model, 'ProvinciaID'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'RegioneID'); ?>
        <?php echo $form->dropDownList($model, 'RegioneID', Html::listData($regioni, 'RegioneID', 'Regione'), array('style' => 'width: 200px;', 'empty' => '--- Seleziona la regione ---')); ?>
        <?php echo $form->error($model, 'RegioneID'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'NazioneID'); ?>
        <?php echo $form->dropDownList($model, 'NazioneID', Html::listData($nazioni, 'NazioneID', 'NazioneIt'), array('style' => 'width: 200px;')); ?>
        <?php echo $form->error($model, 'NazioneID'); ?>
    </div>

    <div class="row buttons">
        <?php echo Html::button($model->isNewRecord ? 'Crea' : 'Aggiorna', array('onclick' => "$('#companyaddress-form').submit();")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
