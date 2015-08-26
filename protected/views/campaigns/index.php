<?php
/* @var $this CampaignsController */
$this->crumbs = array(
    'Campagne',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#campagne-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Campagne</h1>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Nuova campagna', array('/campagna/nuova')); ?><br />
    <?= Html::link('<i class="fa fa-bar-chart"></i> Statistiche campagne', array('/campagne/statistiche')); ?>
</p>

<div id="statusMsg"></div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'aziende-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'CampaignID',
        array(
            'name' => 'Name',
            'header' => 'Nome campagna',
            'htmlOptions' => array("style" => "font-family: Courier New;"),
        ),
        'ScriptTable',
        'Pin',
        'StartDate',
        'EndDate',
        'Notes',
        array(
            'name' => 'Companies',
            'filter' => false,
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Avanzamento',
            'type' => 'raw',
            'value' => '$data->statistiche[\'avanzamentoperc\']'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'deleteConfirmation' => 'Sei sicuro di voler eliminare questa campagna?',
            'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
            'buttons' => array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per andare alla campagna'),
                    'url' => 'CHtml::normalizeUrl(array("campagna/".$data->CampaignID))',
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per eliminare la campagna'),
                ),
            ),
        ),
    ),
    'emptyText' => 'Nessuna campagna presente',
    'summaryText' => 'Campagne {start}-{end} di {count}',
//    'pager' => array(
//        'class' => 'comp.framework.Pager',
//        'header' => 'Pagine:',
//        'firstPageLabel' => '&lt;&lt;',
//        'prevPageLabel' => '&lt;',
//        'nextPageLabel' => '&gt;',
//        'lastPageLabel' => '&gt;&gt;',
//    ),
));
?>

<?php echo CHtml::link('Pulisci i filtri di ricerca', array('index')); ?>