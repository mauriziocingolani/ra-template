<?php
/* @var $this SiteController */

$this->pageTitle = 'Licenza';
$this->crumbs = array(
    $this->pageTitle,
);
$copyright = isset(Yii::app()->params['app']['copyrightUrl']) ?
        Html::link(Yii::app()->params['app']['copyright'], Yii::app()->params['app']['copyrightUrl'], array('target' => 'blank')) :
        Yii::app()->params['app']['copyright'];
?>

<h1>Licenza</h1>

<p>Il gestionale <strong><?php echo Yii::app()->name; ?></strong> è software gratuito, rilasciato nei termini della seguente licenza BSD.</p>

<div class="alert alert-info">

    <p>
        Copyright &copy;<?php echo Yii::app()->params['app']['year']; ?>, <?php echo $copyright; ?><br />
        Tutti i diritti riservati.
    </p>

    <p>
        La ridistribuzione e l'uso in forma di codice sorgente e in forma binaria, con o senza modifiche, &egrave; consentito 
        purch&eacute; siano rispettate le seguenti condizioni:
    </p>

    <ol>
        <li>Le ridistribuzioni del codice sorgente devono conservare la nota di copyright sopra riportata, questa lista di condizioni
            e la seguente limitazione di responsabilit&agrave;.</li>
        <li>Le ridistribuzioni in forma binarie devono riprodurre la nota di copyright sopra riportata, questa lista di condizioni
            e la seguente limitazione di responsabilit&agrave; nella documentazione e/o altri materiali forniti con la distribuzione.</li>
        <li>N&eacute; il nome di <?php echo $copyright; ?>, n&eacute; i nomi dei suoi collaboratori possono essere utilizzati 
            per avallare o promuovere prodotti derivati da questo software senza uno specifico permesso scritto.</li>
    </ol>

    <p>
        Questo software &egrave; fornito da <?php echo $copyright; ?> &ldquo;così com'&egrave;&rdquo; e qualsiasi
        garanzia espressa o implicita, inclusiva di, ma non limitata a, garanzie implicite
        di commerciabilit&agrave; e idoneit&agrave; ad uno scopo particolare, viene disconosciuta. In nessun caso il possessore
        di copyright sar&agrave; ritenuto responsabile per qualsiasi danno diretto, indiretto, connesso, particolare,
        esemplare o conseguente (inclusivo di, ma non limitato a, approvvigionamento di beni o servizi alternativi;
        perdita di utilit&agrave;, dati o profitti; interruzione di affari) comunque causati e su qualsiasi ipotesi di
        responsabilit&agrave;, come da contratto, responsabilit&agrave; oggettiva, o torto (compresa negligenza o altro)
        derivante in qualsiasi modo dall'utilizzo di questo software anche se al corrente della possibilit&agrave; di tale danno.
    </p>

</div>

<p>
    <?php echo Html::link('English', array('/en/license'), array('class' => 'btn btn-default')); ?>
</p>