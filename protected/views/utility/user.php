<?php
/* @var $this UtilityController */
/* @var $model User */
$this->pageTitle = 'Modifica utente';
$this->
        addBreadcrumb('Utility')->
        addBreadcrumb('Gestione utenti', array('/utility/gestione-utenti'))->
        addBreadcrumb($this->pageTitle);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo utente
    <?php else : ?>
        Utente <u><?= $model->UserName; ?></u>
    <?php endif; ?>
</h1>

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

<!-- FORM DATI -->
<?php $this->renderPartial('forms/_user_form', array('model' => $model)); ?>