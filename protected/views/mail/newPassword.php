<?php
/* @var $user User */
/* @var $newPassword string */
/* @var $key string */
?>

<p>Questa è la tua nuova password: <code><?php echo $newPassword; ?></code></p>

<p>Per renderla attiva clicca sul ink qui sotto, oppure incollalo sul tuo browser in caso non venga visualizzato correttamente:</p>

<p>
    <?php
    $url = Yii::app()->getBaseUrl(true) . '/attivazione-nuova-password/' . $key;
    echo Html::link($url, $url);
    ?>
</p>

<p>
    Se non vuoi procedere con l'attivazione non cliccare sul link qui sopra, e la tua vecchia password non verr&agrave; modificata.
</p>