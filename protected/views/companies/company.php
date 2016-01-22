<?php
/* @var $this CompaniesController */
/* @var $model Company */
/* @var $campaignCompany CampaignCompany */
/* @var $campaigns Campaign[] */
$this->pageTitle = $model->isNewRecord ? 'Nuova azienda' : 'Modifica azienda';
$this->
        addBreadcrumb('Aziende', array('/aziende'))->
        addBreadcrumb($this->pageTitle);
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<!-- HEADER -->
<?php if ($model->isNewRecord) : ?>

    <h1>
        Nuova azienda
    </h1>

<?php else : ?>

    <?php $this->renderPartial('_company_pages', array('model' => $model)); ?>

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


    <div style="border-top: 1px solid #C9E0ED;margin-top: 10px;padding-top: 10px;">
        <h3>Campagne associate</h3> 

        <?php if (count($model->Campaigns) > 0) : ?>
            <ul style="list-style: none;padding-left: 0;">
                <?php foreach ($model->Campaigns as $cmp) : ?>
                    <li style="display: inline-block;font-size: 10px;padding-bottom: 15px;">
                        <span class="campaign">
                            <?php if (Yii::app()->user->isSupervisor()) : ?>
                                <a href="#" onclick="return submitDeleteCampaignCompany(<?= $cmp->CampaignCompanyID; ?>)" title="Clicca per disassociare da questa campagna"><i class="fa fa-times"></i></a>
                            <?php endif; ?>
                            <?= Html::encode($cmp->Campaign->Name); ?>
                        </span>
                        <?php if (Yii::app()->user->isSupervisor()) : ?>
                            <form id="<?= $cmp->CampaignCompanyID; ?>_campaigncompany_delete_form" name="DeleteCampaignCompany" method="post">
                                <input name="DeleteCampaignCompany[CampaignCompanyID]" type="hidden" value="<?= $cmp->CampaignCompanyID; ?>" />
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if (Yii::app()->user->isSupervisor()) : ?>
                <script>
                    function submitDeleteCampaignCompany(campaigncompanyid) {
                        if (confirm('Sei sicuro di voler disassociare questa campagna?')) {
                            $('#' + campaigncompanyid + '_campaigncompany_delete_form').submit();
                        }
                        return false;
                    }
                </script>
            <?php endif; ?>

        <?php else : ?>
            <p><em>L'azienda non &egrave; associata a nessuna campagna.</em></p>
        <?php endif; ?>

        <?php
        if (Yii::app()->user->isSupervisor())
            $this->renderPartial('forms/_campaigns_form', array(
                'campaignCompany' => $campaignCompany,
                'campaigns' => $campaigns,
            ));
        ?>

    </div>


<?php endif; ?>
