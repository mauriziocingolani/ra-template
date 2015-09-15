<?php
/* @var $this CampaignsController */
$this->pageTitle = 'Statistiche campagne';
$this->addBreadcrumb('Campagne', array('/campagne'))->
        addBreadcrumb($this->pageTitle);
?>

<h1>Statistiche campagne</h1>

<?php if (count($data) > 0) : ?>

    <?php
# serve solo a far caricare gli asset per CGridView
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => new CActiveDataProvider('Role'),
        'htmlOptions' => array('style' => 'display: none;'),
    ));
    ?>

    <div class="grid-view">
        <table class="items">
            <thead>
                <tr>
                    <th>Campagna</th>
                    <th>Operatori</th>
                    <th>Nominativi</th>
                    <th>De gestire</th>
                    <th>Richiami</th>
                    <th>Chiusi</th>
                    <th>Successi</th>
                    <th>Avanzamento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($data as $d) :
                    ?>
                    <tr class="<?php echo ($i++) % 2 == 0 ? 'even' : 'odd'; ?>">
                        <td><?php echo $d['campaign']->Name; ?></td>
                        <td><small><?php echo Html::JoinFromModels($d['campaign']->Users, 'UserName', '<br />', 'User'); ?></small></td>
                        <td style="text-align: center;"><?php echo $d['stats']['totali']; ?></td>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['dagestire']; ?>
                            <small>(<?php echo $d['stats']['dagestireperc']; ?>)</small>
                        </td>
                        <td style="text-align: center;"><?php echo $d['stats']['richiami']; ?></td>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['chiusi']; ?>
                            <small>(<?php echo $d['stats']['chiusiperc']; ?>)</small>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['successi']; ?>
                            <small>(<?php echo $d['stats']['successiperc']; ?>)</small>
                        </td>
                        <td style="font-weight: bold;text-align: center;"><?php echo $d['stats']['avanzamentoperc']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else : ?>

    <p><em>Nessuna stataistica da mostrare.</em></p>

<?php endif; ?>