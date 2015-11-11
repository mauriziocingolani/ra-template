<?php
/* @var $this CampaignsController */
/* @var $model Campaign */
/* @var $form CActiveForm */
/* @var $operators User[] */
$this->pageTitle = $model->isNewRecord ? 'Nuova campagna' : 'Modifica campagna';
$this->
        addBreadcrumb('Campagne', array('/campagne'))->
        addBreadcrumb($this->pageTitle);
?>

<table>
    <tr>
        <!-- COLONNA SX -->
        <td style="vertical-align: top;width: 70%;">

            <h1>
                <?php if ($model->isNewRecord) : ?>
                    Nuova campagna
                <?php else : ?>
                    Campagna <?= Html::encode($model->Name); ?>
                <?php endif; ?>
            </h1>

            <?php $this->renderPartial('forms/_campaign_form', array('model' => $model)); ?>

        </td>
        <!-- COLONNA DX -->
        <td style="vertical-align: top;width: 30%;">

            <?php if (!$model->isNewRecord) : ?>

                <style>
                    .stats dl dt {
                        color: #298dcd;
                        margin-top: 10px;
                    }
                    .stats dl dd {
                        font-weight: bold;
                        margin-top: 5px;
                    }
                </style>

                <div class="portlet stats">
                    <div class="portlet-decoration">
                        <div class="portlet-title">Statistiche campagna</div>
                    </div>
                    <div class="portlet-content">
                        <?php $stats = $model->getStatistiche(); ?>
                        <dl class="ditta">
                            <dt style="">Nominativi totali</dt>
                            <dd><?php echo $stats['totali']; ?></dd>
                            <dt>Da gestire</dt>
                            <dd><?php echo $stats['dagestire']; ?> <small>(<?php echo $stats['dagestireperc']; ?>)</small></dd>
                            <dt>Richiami</dt>
                            <dd><?php echo $stats['richiami']; ?></dd>
                            <dt>Chiusi</dt>
                            <dd><?php echo $stats['chiusi']; ?> <small>(<?php echo $stats['chiusiperc']; ?>)</small></dd>
                            <dt>Successi</dt>
                            <dd><?php echo $stats['successi']; ?> <small>(<?php echo $stats['successiperc']; ?>)</small></dd>
                            <dt>AVANZAMENTO</dt>
                            <dd style="font-size: 18px;margin-left: 16.2px;"><?php echo $stats['avanzamentoperc']; ?></dd>
                        </dl>
                    </div>
                </div>

            <?php endif; ?>

        </td>
    </tr>
</table>

<?php if (!$model->isNewRecord) : ?>

    <div style="margin-top: 15px;">

        <h3>Operatori</h3>

        <?php $this->widget('widgets.FlashWidget', array('prefix' => 'operators')); ?>

        <style>
            ul.operators {
                -webkit-column-count: 4; -webkit-column-gap:10px; 
                -moz-column-count:4; -moz-column-gap:10px; 
                -o-column-count:4; -o-column-gap:10px; 
                column-count:4; column-gap:10px; 
            }                
        </style>

        <form id="CampaignOperators" action="/campagna/<?= $model->CampaignID; ?>" method="post">
            <input name="CampaignOperators[foo]" type="hidden" value="bar" />
            <ul class="operators">
                <?php foreach ($operators as $op) : ?>
                    <li>
                        <input id="<?= $op->UserID; ?>_op_cb" name="CampaignOperators[<?= $op->UserID; ?>]" type="checkbox" 
                               <?php if ($model->hasUser($op->UserID)) echo 'checked'; ?>/>
                        <label for="<?= $op->UserID; ?>_op_cb"><?= Html::encode($op->UserName); ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="row buttons" style="margin-top: 15px;">
                <?php echo CHtml::submitButton('Aggiorna lista operatori'); ?>
            </div>
        </form>

    </div>

<?php endif; ?>