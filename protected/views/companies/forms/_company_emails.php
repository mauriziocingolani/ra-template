<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $emails CompanyEmail[] */
$emails = $model->Emails;
?>

<h3 style="margin-bottom: 5px;">Email</h3>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Aggiungi', array("/azienda/{$model->CompanyID}/email/nuova")); ?>
</p>

<?php if (is_array($emails) && count($emails) > 0) : ?>

    <?php foreach ($emails as $email) : ?>
        <p style="margin-bottom: 5px;">
            <?=
            Html::link('<i class="fa fa-pencil"></i>', array("/azienda/{$model->CompanyID}/email/{$email->CompanyEmailID}")
                    , array('title' => 'Clicca per modificare l\'indirizzo email'));
            ?>
            <?=
            Html::link('<i class="fa fa-trash-o"></i>', '#'
                    , array('onclick' => "return deleteEmail({$email->CompanyEmailID});", 'title' => 'Clicca per eliminare l\'indirizzo email'));
            ?>
            <span style="margin-left: 10px;"><?= $email->Address; ?></span><br />
        </p>
        <form id="<?= $email->CompanyEmailID; ?>_email_delete_form" action="/azienda/<?= $model->CompanyID; ?>" method="post">
            <input name="CompanyEmail[Delete]" type="hidden" value="<?= $email->CompanyEmailID; ?>" />
        </form>
    <?php endforeach; ?>

<?php else : ?>

    <p><em>Nessuna email per questa azienda.</em></p>

<?php endif; ?>

<script>
    function deleteEmail(companyemailid) {
        if (confirm('Sei sicuro di voler eliminare questo indirizzo email?'))
            $('#' + companyemailid + '_email_delete_form').submit();
        return false;
    }
</script>