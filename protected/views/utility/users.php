<?php
/* @var $this UtilityController */
/* @var $model User */
/* @var $form CActiveForm */
$this->pageTitle = 'Utenti';
$this->
        addBreadcrumb('Utility')->
        addBreadcrumb($this->pageTitle);
?>

<h1>Utenti</h1>

<p>
    <?= Html::link('<i class="fa fa-plus-circle"></i> Nuovo utente', array('/utility/creazione-utente')); ?><br />
</p>

<div id="statusMsg"></div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'users-grid',
    'dataProvider' => $user->search(),
    'filter' => $user,
    'rowCssClassExpression' => '( $row%2 ? $this->rowCssClass[1] : $this->rowCssClass[0] ) .' .
    '( $data->Enabled ? null:" disabled")',
    'columns' => array(
        'UserID',
        'UserName',
        'Email',
        array(
            'name' => 'roleSearch',
            'value' => '$data->Role->Description',
        ),
//        'ScriptTable',
//        'Pin',
//        'StartDate',
//        'EndDate',
//        'Notes',
//        array(
//            'name' => 'Companies',
//            'filter' => false,
//            'htmlOptions' => array('style' => 'text-align: center;'),
//        ),
//        array(
//            'header' => 'Avanzamento',
//            'type' => 'raw',
//            'value' => '$data->statistiche[\'avanzamentoperc\']'
//        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'deleteConfirmation' => 'Sei sicuro di voler eliminare questo utente?',
            'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
            'buttons' => array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per modificare l\'utente'),
                    'url' => 'CHtml::normalizeUrl(array("utility/gastione-utente/".$data->UserID))',
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash"></i>',
                    'imageUrl' => false,
                    'options' => array('title' => 'Clicca per eliminare l\'utente'),
                ),
            ),
        ),
    ),
    'emptyText' => 'Nessun utente presente',
    'summaryText' => 'Utenti {start}-{end} di {count}',
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

<?php echo CHtml::link('Pulisci i filtri di ricerca', array('/utility/gestione-utenti')); ?>