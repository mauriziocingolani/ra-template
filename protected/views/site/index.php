<?php
/* @var $this SiteController */
?>

<?php if (Yii::app()->user->isGuest) : ?>

    Per accedere alle funzionalit&agrave; del gestionale devi <?= Html::link('autenticarti', array('/login')); ?>.

    <div style="height: 250px;"></div>

<?php else : ?>

    <!-- WELCOME -->
    <p>Benvenut<?= Yii::app()->user->user->genderSuffix; ?> <strong><?= Html::encode(Yii::app()->user->user->completeName); ?></strong>,</p>
    <p>
        attualmente sei abilitat<?= Yii::app()->user->user->genderSuffix; ?> all'uso del gestionale come utente di classe
        <strong><?= Yii::app()->user->user->Role->Description; ?></strong>.
    </p>

    <!-- UTILITY -->
    <?php if (Yii::app()->user->isSupervisor()) : ?>

        <hr />
        <p>Queste funzioni sono riservate agli utenti della tua classe:</p>

        <h3>Utility</h3>
        <ul>
            <?php if (Yii::app()->user->isDeveloper()) : ?>
                <li><?= Html::link('Pulizia db', array('/utility/pulizia-db')); ?></li>
                <li><?= Html::link('Pulizia cache', array('/utility/pulizia-cache')); ?></li>
                <li><?= Html::link('Gestione utenti', array('/utility/gestione-utenti')); ?></li>
                <li>... per Developer ...</li>
            <?php endif; ?>
            <li>...</li>
            <li>... per Supervisor ...</li>
            <li>... per Supervisor ...</li>
        </ul>

        <h3>Reports</h3>
        <ul>
            <li><?= Html::link('Report campagne', array('/reports/report-campagne')); ?></li>
        </ul>

    <?php endif; ?>

    <!-- CAMPAGNE -->
    <?php
    $campaigns = Yii::app()->user->user->activeCampaigns;
    $hasCompanies = false;
    ?>

    <?php if (count($campaigns) > 0) : ?>

        <hr />

        <h3>Le tue campagne</h3>

        <?php foreach ($campaigns as $camp) : ?>
            <?php $todo = $camp->toDoCompanies; ?>
            <?php $recall = $camp->recallCompanies; ?>

            <?php if (count($todo) > 0 || count($recall) > 0) : $hasCompanies = true; ?>
                <div class="campaign" style="font-family: Courier New;">
                    <?= Html::encode($camp->Campaign->Name); ?>
                </div>
                <table>
                    <tr>
                        <!-- DA GESTIRE -->
                        <td style="vertical-align: top;width: 50%;">
                            <h4>Da gestire</h4>
                            <p>
                                <?php if (count($todo) > 0) : ?>
                                    Hai <?= count($todo); ?> agenzie da gestire.
                                <?php else : ?>
                                    <em>Al momento non hai agenzie da gestire per questa campagna.</em>
                                <?php endif; ?>
                            </p>
                            <div style="border: 1px solid #c9e0da;font-size: 11px;max-height: 200px;overflow: auto;padding: 10px;">
                                <ul>
                                    <?php foreach ($todo as $comp) : ?>
                                        <li><?= Html::link($comp->CompanyName, array("/azienda/{$comp->CompanyID}/profilazione/{$camp->CampaignID}")); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </td>
                        <!-- RICHIAMI -->
                        <td style="vertical-align: top;width: 50%;">
                            <h4>Da richiamare</h4>

                            <?php if (count($recall) > 0) : ?>

                                <p>
                                    Hai <?= count($recall); ?> agenzie da richiamare.
                                </p>
                                <div style="border: 1px solid #c9e0da;font-size: 11px;max-height: 200px;overflow: auto;padding: 10px;">
                                    <ul>
                                        <?php foreach ($recall as $act) : ?>
                                            <li>
                                                <span style="font-weight: bold;<?php if ($act->RecallPrioritary) echo 'background: yellow;'; ?>"><?= date('d-m-Y H:i', strtotime($act->RecallDateTime)); ?></span>
                                                <?= Html::link($act->Company->CompanyName, array("/azienda/{$act->CompanyID}/profilazione/{$camp->CampaignID}")); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php else : ?>

                                <p><em>Al momento non hai agenzie da richiamare per questa campagna.</em></p>

                            <?php endif; ?>

                        </td>
                    </tr>
                </table>
            <?php endif; ?>

        <?php endforeach; ?>

        <?php if (!$hasCompanies) : ?>
            <p><em>Non hai aziende da gestire per le tue campagne.</em></p>
        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>

