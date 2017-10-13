<?php

$home = dirname(__FILE__);
# cartella assets
echo 'Check cartella /assets... ';
$assetsFolder = $home . '/assets';
if (!file_exists($assetsFolder)) :
    mkdir($assetsFolder);
    chmod($assetsFolder, 0777);
    echo "creata. OK\n";
else :
    echo "presente. OK\n";
endif;
# cartella assets
echo 'Check cartella /protected/runtime... ';
$runtimeFolder = $home . '/protected/runtime';
if (!file_exists($runtimeFolder)) :
    mkdir($runtimeFolder);
    chmod($runtimeFolder, 0777);
    echo "creata. OK\n";
else :
    echo "presente. OK\n";
endif;

