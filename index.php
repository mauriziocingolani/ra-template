<?php

if (false) :
    require './init.php';
    die();
endif;

// change the following paths if necessary
$yii = dirname(__FILE__) . '/../yii/framework.1.20/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

require './debug.php';

if (YII_DEBUG) :
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    error_reporting(E_ALL);
    ini_set('display_errors', '-1');
endif;

//Start Yii
require_once($yii);
$app = Yii::createWebApplication($config);
/* PHP Excel */
Yii::import('ext.yiiexcel.YiiExcel', true);
Yii::registerAutoloader(array('YiiExcel', 'autoload'), true);
PHPExcel_Shared_ZipStreamWrapper::register();
if (ini_get('mbstring.func_overload') & 2) :
    throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
endif;
PHPExcel_Shared_String::buildCharacterSets();
/* Avvio applicazione */
$app->run();
