<?php
/* @var $this CompaniesController */
/* @var $companies Company[] */
$this->crumbs = array(
    'Aziende',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aziende-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Aziende</h1>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Nuova azienda', array('/azienda/nuova')); ?>
</p>

<div id="statusMsg"></div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'aziende-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'CompanyID',
        'CompanyName',
        'CompanyLegalName',
        'CompanyGroup',
        'CompanyCode',
        array(
            'header' => 'Citt&agrave;',
            'value' => 'Html::JoinFromModels($data->Addresses,"City")',
            'filter' => Html::activeTextField($model->searchCity, 'City'),
        ),
        array(
            'header' => 'Telefoni',
            'value' => 'Html::JoinFromModels($data->Phones,"PhoneNumber")',
            'filter' => Html::activeTextField($model->searchPhone, 'PhoneNumber'),
        ),
        array(
            'header' => 'Email',
            'value' => 'Html::JoinFromModels($data->Emails,"Address")',
            'filter' => Html::activeTextField($model->searchEmail, 'Address'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'deleteConfirmation' => 'Sei sicuro di voler eliminare questa azienda?',
            'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
            'buttons' => array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per andare alla scheda dell\'azienda'),
                    'url' => 'CHtml::normalizeUrl(array("azienda/".$data->CompanyID))',
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per eliminare l\'azienda'),
                ),
            ),
        ),
    ),
    'emptyText' => 'Nessuna azienda presente',
    'summaryText' => 'Aziende {start}-{end} di {count}',
    'pager' => array(
        'class' => 'comp.framework.Pager',
        'header' => 'Pagine:',
        'firstPageLabel' => '&lt;&lt;',
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'lastPageLabel' => '&gt;&gt;',
    ),
));
?>

<?php echo CHtml::link('Pulisci i filtri di ricerca', array('index')); ?>