<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $contacts CompanyContact[] */
$contacts = $model->Contacts;
?>

<h3 style="margin-bottom: 5px;">Contatti</h3>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Aggiungi', array("/azienda/{$model->CompanyID}/contatto/nuovo")); ?>
</p>

<?php if (is_array($contacts) && count($contacts) > 0) : ?>

    <?php foreach ($contacts as $contact) : ?>
        <table>
            <tr>
                <td style="vertical-align: top;width: 30px;">
                    <?=
                    Html::link('<i class="fa fa-pencil"></i>', array("/azienda/{$model->CompanyID}/contatto/{$contact->ContactID}")
                            , array('title' => 'Clicca per modificare il contatto'));
                    ?>
                    <?=
                    Html::link('<i class="fa fa-trash-o"></i>', '#'
                            , array('onclick' => "return deleteContact({$contact->ContactID});", 'title' => 'Clicca per eliminare il contatto'));
                    ?>
                </td>
                <td style="padding-left: 0;vertical-align: top;">
                    <strong><?= Html::encode($contact->getCompleteName()); ?></strong>
                    <?php if ($contact->Role) : ?>(<em><?= Html::encode($contact->Role); ?></em>)<?php endif; ?>
                    <?php if ($contact->Phone) : ?><br /><?= $contact->Phone; ?><?php endif; ?>
                    <?php if ($contact->Email) : ?><br /><em><?= $contact->Email; ?></em><?php endif; ?>
                    <?php if ($contact->Notes) : ?><br /><span style="font-family: Courier New;font-size:12px;"><?= Html::encode($contact->Notes); ?></span><?php endif; ?>
                </td>
            </tr>
        </table>
        <form id="<?= $contact->ContactID; ?>_contact_delete_form" action="/azienda/<?= $model->CompanyID; ?>" method="post">
            <input name="CompanyContact[Delete]" type="hidden" value="<?= $contact->ContactID; ?>" />
        </form>
    <?php endforeach; ?>

<?php else : ?>

    <p><em>Nessun contatto per questa azienda.</em></p>

<?php endif; ?>

<script>
    function deleteContact(contactid) {
        if (confirm('Sei sicuro di voler eliminare questo contatto?'))
            $('#' + contactid + '_contact_delete_form').submit();
        return false;
    }
</script>