<?php
/* @var $this UtilityController */
/* @var $model User */
/* @var $form CActiveForm */
$this->pageTitle = 'Creazione utente';
$this->crumbs = array(
    'Utility',
    $this->pageTitle,
);
?>

<h1>Creazione utente</h1>

<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>

    <?php echo Html::link('Crea un altro utente', array('/utility/creazione-utente')); ?>

<?php else : ?>

    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

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

        <div class="row buttons">
            <?php echo CHtml::submitButton('Crea nuovo utente'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

<?php endif; ?>