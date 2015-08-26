<?php
/* @var $this CompaniesController */
/* @var $model Company */
$this->crumbs = array(
    'Aziende' => array('/aziende'),
    $model->isNewRecord ? 'Nuova azienda' : 'Modifica azienda',
);
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<!-- HEADER -->
<?php if ($model->isNewRecord) : ?>

    <h1>
        Nuova azienda
    </h1>

<?php else : ?>

    <?php $this->renderPartial('forms/_company_pages', array('model' => $model)); ?>

    <h1>
        Azienda <u><?= Html::encode($model->CompanyName); ?></u>
    </h1>
    <p style="color: #bababa;font-size: 10px;font-style: italic;"><?= $model->getCreatedUpdatedString(); ?></p>

<?php endif; ?>

<!-- FORM DATI -->
<?php $this->renderPartial('forms/_company_form', array('model' => $model)); ?>

<!-- DATI AGGIUNTIVI -->
<?php if (!$model->isNewRecord) : ?>

    <div style="border-top: 1px solid #C9E0ED;margin-top: 10px;padding-top: 10px;">
        <table>
            <tr>
                <td style="vertical-align: top;width: 50%;">
                    <!-- Indirizzi -->
                    <?php $this->renderPartial('forms/_company_addresses', array('model' => $model)); ?>
                </td>
                <td style="vertical-align: top;width: 50%;">
                    <!-- Contatti -->
                    <?php $this->renderPartial('forms/_company_contacts', array('model' => $model)); ?>
                </td>
            </tr>
        </table>
    </div>

    <div style="border-top: 1px solid #C9E0ED;margin-top: 10px;padding-top: 10px;">
        <table>
            <tr>
                <td style="vertical-align: top;width: 50%;">
                    <!-- Telefoni -->
                    <?php $this->renderPartial('forms/_company_phones', array('model' => $model)); ?>
                </td>
                <td style="vertical-align: top;width: 50%;">
                    <!-- Email -->
                    <?php $this->renderPartial('forms/_company_emails', array('model' => $model)); ?>
                </td>
            </tr>
        </table>
    </div>

<?php endif; ?>
