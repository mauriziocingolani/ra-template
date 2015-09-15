<?php
/* @var $this UserController */

$this->pageTitle = Yii::app()->name . ' - Password dimenticata';
?>

<h1>Password dimenticata</h1>

<?php if (Yii::app()->user->hasFlash('success')) : ?>

    <div class="flash-success">
        La tua richiesta &egrave; andata a buon fine. A breve riceverai un messaggio
        al tuo indirizzo email con la nuova password e con  le istruzioni per renderla attiva.
    </div>

<?php else : ?>

    <p>
        Se hai dimenticato la password puoi chiedere che te ne venga assegnata una nuova.
        Inserisci il tuo nome utente o il tuo indirizzo email nel campo sottostante; riceverai un
        messaggio con le istruzioni per resettare la password.
    </p>


    <?php if (Yii::app()->user->hasFlash('error')) : ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'forgottenpassword-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Richiedi reset password'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

<?php endif; ?>
