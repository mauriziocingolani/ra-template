<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $phones CompanyPhone[] */
$phones = $model->Phones;
?>

<h3 style="margin-bottom: 5px;">Telefoni</h3>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Aggiungi', array("/azienda/{$model->CompanyID}/telefono/nuovo")); ?>
</p>

<?php if (is_array($phones) && count($phones) > 0) : ?>

    <?php foreach ($phones as $phone) : ?>
        <p style="margin-bottom: 5px;">
            <?=
            Html::link('<i class="fa fa-pencil"></i>', array("/azienda/{$model->CompanyID}/telefono/{$phone->CompanyPhoneID}")
                    , array('title' => 'Clicca per modificare il telefono'));
            ?>
            <?=
            Html::link('<i class="fa fa-trash-o"></i>', '#'
                    , array('onclick' => "return deletePhone({$phone->CompanyPhoneID});", 'title' => 'Clicca per eliminare il telefono'));
            ?>
            <?php if ($phone->PhoneType != 'Fax') : ?>
                <?= Html::link('<i class="fa fa-phone"></i>', 'callto:' . Yii::app()->params['prefix'] . preg_replace('/[^0-9]/', '', $phone->PhoneNumber)); ?>
            <?php else : ?>
                <span style="display: inline-block;width: 11px;">&nbsp;</span>
            <?php endif; ?>
            <span style="margin-left: 10px;">
                <?= $phone->PhoneNumber; ?>
                (<?= $phone->PhoneType; ?>)
            </span><br />
        </p>
        <form id="<?= $phone->CompanyPhoneID; ?>_phone_delete_form" action="/azienda/<?= $model->CompanyID; ?>" method="post">
            <input name="CompanyPhone[Delete]" type="hidden" value="<?= $phone->CompanyPhoneID; ?>" />
        </form>
    <?php endforeach; ?>

<?php else : ?>

    <p><em>Nessun telefono per questa azienda.</em></p>

<?php endif; ?>

<script>
    function deletePhone(companyphoneid) {
        if (confirm('Sei sicuro di voler eliminare questo telefono?'))
            $('#' + companyphoneid + '_phone_delete_form').submit();
        return false;
    }
</script>