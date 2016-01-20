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
                    <th>Tickets</th>
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
                $tots = array('totali' => 0, 'dagestire' => 0, 'richiami' => 0, 'chiusi' => 0, 'successi' => 0);
                foreach ($data as $d) :
                    ?>
                    <tr class="<?php echo ($i++) % 2 == 0 ? 'even' : 'odd'; ?>">
                        <td><?php echo $d['campaign']->Name; ?></td>
                        <td><small><?php echo Html::JoinFromModels($d['campaign']->Users, 'UserName', '<br />', 'User'); ?></small></td>
                        <td style="text-align: center;"><?php echo $d['stats']['totali']; ?></td>
                        <!-- TOT --><?php $tots['totali']+=$d['stats']['totali']; ?>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['dagestire']; ?>
                            <small>(<?php echo $d['stats']['dagestireperc']; ?>)</small>
                        </td>
                        <!-- TOT --><?php $tots['dagestire']+=$d['stats']['dagestire']; ?>
                        <td style="text-align: center;"><?php echo $d['stats']['richiami']; ?></td>
                        <!-- TOT --><?php $tots['richiami']+=$d['stats']['richiami']; ?>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['chiusi']; ?>
                            <small>(<?php echo $d['stats']['chiusiperc']; ?>)</small>
                        </td>
                        <!-- TOT --><?php $tots['chiusi']+=$d['stats']['chiusi']; ?>
                        <td style="text-align: center;">
                            <?php echo $d['stats']['successi']; ?>
                            <small>(<?php echo $d['stats']['successiperc']; ?>)</small>
                        </td>
                        <!-- TOT --><?php $tots['successi']+=$d['stats']['successi']; ?>
                        <td style="font-weight: bold;text-align: center;"><?php echo $d['stats']['avanzamentoperc']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" />
                    <th><?php echo $tots['totali']; ?></th>
                    <th>
                        <?php echo $tots['dagestire']; ?>
                        <small>(<?php echo sprintf('%.1f', $tots['dagestire'] / $tots['totali'] * 100); ?>&percnt;)</small>
                    </th>
                    <th><?php echo $tots['richiami']; ?></th>
                    <th>
                        <?php echo $tots['chiusi']; ?>
                        <small>(
                            <?php echo sprintf('%.1f', $tots['totali'] - $tots['dagestire'] > 0 ? $tots['chiusi'] / ($tots['totali'] - $tots['dagestire']) * 100 : 0.0); ?>
                            &percnt;)</small>
                    </th>
                    <th>
                        <?php echo $tots['successi']; ?>
                        <small>(
                            <?php echo sprintf('%.1f', $tots['chiusi'] > 0 ? $tots['successi'] / $tots['chiusi'] * 100 : 0.0); ?>
                            &percnt;)</small>
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

<?php else : ?>

    <p><em>Nessuna stataistica da mostrare.</em></p>

<?php endif; ?>