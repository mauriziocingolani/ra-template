<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $campaigns CampaignCompany[] */
/* @var $campaignid integer */
/* @var $campaignName string */
/* @var $activity Activity */
$this->pageTitle = 'Profilazione';
$this->
        addBreadcrumb('Aziende', array('/aziende'))->
        addBreadcrumb("Azienda {$model->CompanyName}", array("/azienda/{$model->CompanyID}"))->
        addBreadcrumb($this->pageTitle);
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<?php $this->renderPartial('_company_pages', array('model' => $model)); ?>

<h1>
    Azienda <u><?= Html::encode($model->CompanyName); ?></u> - PROFILAZIONE
    <?php if ($campaignid) : ?>
        <small>(campagna <u><?= Html::encode($campaignName); ?></u>)</small>
    <?php endif; ?>
</h1>

<!-- LISTA TELEFONI -->
<p>
    <?php foreach ($model->Phones as $phone) : ?>
        <?php if ($phone->PhoneType != 'Fax') : ?>
            <?= Html::link('<i class="fa fa-phone"></i>', 'callto:' . trim($pin) . trim(preg_replace('/[^0-9]/', '', $phone->PhoneNumber))); ?>
        <?php else : ?>
            <span style="display: inline-block;width: 11px;">&nbsp;</span>
        <?php endif; ?>
        <span style="margin-left: 10px;">
            <?= trim($pin) . trim($phone->PhoneNumber); ?>
            (<?= $phone->PhoneType; ?>)
        </span><br />
    <?php endforeach; ?>
</p>

<!-- INFO CREAZIONE/MODIFICA -->
<p style="color: #bababa;font-size: 10px;font-style: italic;"><?= $model->getCreatedUpdatedString(); ?></p>

<!-- SELETTORE CAMPAGNE -->
<?php if ($campaignid) : ?>
    <select id="campaigns">
        <?php foreach ($campaigns as $cc) : ?>
            <option value="<?= $cc->Campaign->CampaignID; ?>" <?php if ($cc->Campaign->CampaignID == $campaignid) echo 'selected'; ?>>
                <?= Html::encode($cc->Campaign->Name); ?>
            </option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

<table style="margin-top: 15px;">
    <tr>

        <!-- COLONNA SX -->
        <td style="vertical-align: top;width: 50%;">

            <div class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">
                        Profilazione
                        <?php if ($campaignid) : ?>
                            <small>(campagna <u><?= Html::encode($campaignName); ?></u>)</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-content">
                    <?php if ($campaignid) : ?>
                        <div class="form">
                            <p style="background: yellow;font-weight: bold;padding: 5px;">ATTENZIONE: prima aggiornare la profilazione, poi registrare l'attivit&agrave;!</p>
                            <?php $this->renderPartial('scripts/_' . get_class($profileModel), array('model' => $profileModel)); ?>
                        </div>
                    <?php else : ?>
                        <em>Questa agenzia non &egrave; associata a nessuna delle tue campagne, 
                            oppure &egrave; stata profilata e chiusa, 
                            quindi non pu&ograve; essere profilata.</em>
                    <?php endif; ?>
                </div>
            </div>

        </td>

        <!-- COLONNA DX -->
        <td style="vertical-align: top;width: 50%;">
            <div class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">
                        Attivit&agrave;
                    </div>
                </div>
                <div class="portlet-content">

                    <?php if ($campaignid) : ?>
                        <?php $this->renderPartial('forms/_activity_form', array('company' => $model, 'activity' => $activity, 'campaignid' => $campaignid)); ?>
                    <?php else : ?>
                        <em>Questa agenzia non &egrave; associata a nessuna delle tue campagne, 
                            oppure &egrave; stata profilata e chiusa, 
                            quindi non &egrave; possibile registrare attivit&agrave;.</em>
                    <?php endif; ?>
                    <hr />
                    <h5>Storico attivit&agrave;</h5>

                    <?php $activities = $model->allActivities; ?>

                    <?php if (is_array($activities) && count($activities) > 0) : ?>

                        <p>
                            <small>
                                <a href="" onclick="expandCollapseAll(true);return false;">Espandi</a>
                                |
                                <a href="" onclick="expandCollapseAll(false);return false;">Chiudi</a>
                                tutte le attivit&agrave;
                            </small>
                        </p>

                        <?php foreach ($activities as $campaignid => $cData) : ?>

                            <!-- campagna -->
                            <div class="campaign">
                                <strong><?= Html::encode($cData['campaign']->Name); ?></strong>
                                <small style="color: gray;">(<?= $cData['campaign']->dates; ?>)</small>
                            </div>

                            <?php foreach ($cData['activities'] as $act) : ?>

                                <?php $this->widget('widgets.ActivityWidget', array('activity' => $act)); ?>

                            <?php endforeach; ?>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <p><em>Nessuna attivit&agrave; presente.</em></p>

                    <?php endif; ?>
                </div>
            </div>
        </td>

    </tr>
</table>

<?php $profiles = $model->getAllProfiles(); ?>
<?php if (count($profiles) > 0) : ?>

    <hr />
    <h3>Storico profilazioni</h3>
    <?php foreach ($profiles as $campagna => $d) : ?>
        <div class="campaign">
            <strong><?= Html::encode($campagna); ?></strong>
            <span style="color: gray;float: right;"><?php echo date('d/m/Y', $d['timestamp']); ?></span>
        </div>
        <p>
            <?php foreach ($d['answers'] as $question => $answer) : ?>
                <strong><?= $question; ?></strong>
                <?= $answer; ?>
                <br />
            <?php endforeach; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(function () {
        $('a.expander').click(function () {
            var id = $(this).attr('id').substring(0, $(this).attr('id').indexOf('_'));
            var div = $('#' + id + '_details');
            if (div.is(':visible')) {
                $('#' + id + '_expander i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                div.slideUp('fast');
            } else {
                $('#' + id + '_expander i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                div.slideDown('fast');
            }
        });
        $('#campaigns').change(function (event) {
            var newCampaign = $(event.target).val();
            var oldCampaign = location.href.split('/');
            oldCampaign.pop();
            oldCampaign.push(newCampaign);
            location.href = oldCampaign.join('/');
        });
    });
    function submitDeleteActivity(activityid) {
        if (confirm('Sei sicuro di voler eliminare questa attività?')) {
            $('#' + activityid + '_activity_delete_form').submit();
        }
        return false;
    }
    function expandCollapseAll(expand) {
        $('.expander').each(function (i, a) {
            var id = $(a).attr('id').substring(0, $(a).attr('id').indexOf('_'));
            var div = $('#' + id + '_details');
            if (expand) {
                $('#' + id + '_expander i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                div.slideDown('fast');
            } else {
                $('#' + id + '_expander i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                div.slideUp('fast');
            }
        });
    }
</script>