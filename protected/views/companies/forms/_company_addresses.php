<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $addresses CompanyAddress[] */
$addresses = $model->Addresses;
?>

<h3 style="margin-bottom: 5px;">Indirizzi</h3>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Aggiungi', array("/azienda/{$model->CompanyID}/indirizzo/nuovo")); ?>
</p>

<?php if (is_array($addresses) && count($addresses) > 0) : ?>

    <?php foreach ($addresses as $address) : ?>
        <p style="margin-bottom: 5px;">
            <?=
            Html::link('<i class="fa fa-pencil"></i>', array("/azienda/{$model->CompanyID}/indirizzo/{$address->CompanyAddressID}")
                    , array('title' => 'Clicca per modificare l\'indirizzo'));
            ?>
            <?=
            Html::link('<i class="fa fa-trash-o"></i>', '#'
                    , array('onclick' => "return deleteAddress({$address->CompanyAddressID});", 'title' => 'Clicca per eliminare l\'indirizzo'));
            ?>
            <strong><?= $address->AddressType; ?></strong>
        </p>
        <p>

            <span style="line-height: 1.5em;">
                <?= Html::encode($address->Address); ?>
            </span><br >
            <span style="line-height: 1.5em;">
                <?php if ($address->ZipCode) : ?><?= $address->ZipCode; ?>  - <?php endif; ?>
                <?= Html::encode($address->City); ?>
                <?php if ($address->ProvinciaID) : ?>(<?= $address->Provincia->Sigla; ?>)<?php endif; ?>
            </span><br />
            <span style="line-height: 1.5em;">
                <?php if ($address->RegioneID) : ?><?= Html::encode($address->Regione->Regione); ?>  - <?php endif; ?>
                <?= Html::encode($address->Nazione->NazioneIt); ?>
            </span><br >
        </p>
        <form id="<?= $address->CompanyAddressID; ?>_address_delete_form" action="/azienda/<?= $model->CompanyID; ?>" method="post">
            <input name="CompanyAddress[Delete]" type="hidden" value="<?= $address->CompanyAddressID; ?>" />
        </form>
    <?php endforeach; ?>

<?php else : ?>

    <p><em>Nessun indirizzo per questa azienda.</em></p>

<?php endif; ?>

    <script>
    function deleteAddress(companyaddressid) {
        if (confirm('Sei sicuro di voler eliminare questo indirizzo?'))
            $('#' + companyaddressid + '_address_delete_form').submit();
        return false;
    }
</script>
