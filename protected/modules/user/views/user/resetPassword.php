<?php
/* @var $this UserController */

$this->pageTitle = Yii::app()->name . ' - Attivazione nuova password';
?>

<h1>Attivazione nuova password</h1>

<?php if ($error === false) : ?>

    <div class="flash-success">
        La tua nuova password è attiva!
    </div>

<?php else : ?>

    <div class="flash-error">

        <?php if (is_string($error)) : ?>

            <p>
                Impossibile resettare la password.
                <?php if (YII_DEBUG) : ?>
                    Il server riporta:
                <p><em><?php echo $error; ?></em></p>
            <?php endif; ?>
        </p>

    <?php else : ?>

        <p>Non &egrave; stato possibile resettare la password. Il link di attivazione che hai ricevuto per email non &egrave;
            valido, e quindi la tua vecchia password non &egrave; stata modificata. Possiblii motivi:
        </p>
        <ul>
            <li>Se hai copiato e incollato manualmente il link di attivazione sul browser assicurati di non aver
                commesso errori e di aver selezionato tutto il testo del link, senza dimenticare nessun carattere.</li>
            <li>Se hai fatto altre richieste di reset successiva a questa, utilizza il link che trovi nel messaggio email
                pi&ugrave; recente, dato che ogni richiesta di reset invalida quelle precedenti.</li>
        </ul>

    <?php endif; ?>

    </div>

<?php endif; ?>
