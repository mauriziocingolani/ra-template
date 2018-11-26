<?php
/* @var $form CActiveForm */
/* @var $model User */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'RoleID'); ?>
        <?php echo $form->dropDownList($model, 'RoleID', Html::listData(Role::GetAll(), 'RoleID', 'Description')); ?>
        <?php echo $form->error($model, 'RoleID'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'UserName'); ?>
        <?php echo $form->textField($model, 'UserName', array('size' => 25)); ?>
        <?php echo $form->error($model, 'UserName'); ?>
    </div>
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
        <?php echo $form->labelEx($model, 'Gender'); ?>
        <?php echo $form->dropDownList($model, 'Gender', $model->getGenderOptions()); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Email'); ?>
        <?php echo $form->emailField($model, 'Email', array('size' => 40)); ?>
        <?php echo $form->error($model, 'Email'); ?>
    </div>
    <?php if (!$model->isNewRecord) : ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'Enabled'); ?>
        <?php echo $form->checkBox($model, 'Enabled'); ?>
        <?php echo $form->error($model, 'Enabled'); ?>
    </div>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Crea nuovo utente' : 'Aggiorna'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>