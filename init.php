<?php

$folder = dirname(__FILE__);
$folders = array('assets', 'protected/runtime', 'files', 'files/reports', 'files/uploads');

foreach ($folders as $f) :
    if (!file_exists("$folder/$f")) :
        mkdir("$folder/$f", 0777);
        echo "* Creata cartella /$f con permessi 0777\r\n";
    elseif (fileperms("$folder/$f") != 16895) :
        chmod("$folder/$f", 0777);
        echo "* Modificati permessi cartella /$f in 0777\r\n";
    else :
        echo "* Cartella /$f ok\r\n";
    endif;
endforeach;

