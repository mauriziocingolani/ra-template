<?php
/* @var $this CompaniesController */
/* @var $model Script33acb33Recall */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Script1a0f3f9Test-form',
    'enableAjaxValidation' => false,
        ));
?>

<p class="note"><span class="required">*</span> campi obbligatori.</p>

<?php $this->widget('widgets.FlashWidget', array('prefix' => get_class($model))); ?>

<div class="row" style="margin-bottom: 25px;">
    <?= $form->labelEx($model, 'Q1'); ?>
    <?= $form->textField($model, 'Q1'); ?>
    <?= $form->error($model, 'Q1'); ?>
</div>
<div class="row" style="margin-bottom: 25px;">
    <?= $form->labelEx($model, 'Q2'); ?>
    <?= Html::enumDropDownList($model, 'Q2', array('empty' => '--- seleziona una voce ---')); ?><br />
    <?= $form->textField($model, 'Q2t', array('size' => 30, 'placeholder' => 'Altro...', 'style' => 'display: ' . ($model->Q2 == 'Altro' ? 'inline-block' : 'none') . ';')); ?><br />
    <?= $form->error($model, 'Q0'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton('Aggiorna'); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(function () {
        $('#Script1a0f3f9Test_Q2').change(function (event) {
            $('#Script1a0f3f9Test_Q2t').css('display', $(event.target).val() == 'Altro' ? 'inline-block' : 'none');
        });
    });
</script>