<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/components/framework/Config.php';
$config = new Config('Remote Account - Template', 'files');
$config->addAlias(array(
    'comp' => 'application.components',
    'modules' => 'application.modules',
    'widgets' => 'application.components.widgets',
));
$config->addComponent(array(
//    'cache' => array(
//        'class' => 'system.caching.CDbCache',
//        'connectionID' => 'db',
//    ),
//    'twitter' => require(dirname(__FILE__) . '/files/twitter.php'),
    'user' => array(
        'class' => 'comp.ApplicationWebUser',
        'allowAutoLogin' => false,
        'loginUrl' => array('login'),
    ),
));
$config->addDbComponent();
$config->addModule(array(
    'user',
    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'cing11235MAUR',
        'ipFilters' => array('194.168.0.84', '82.85.62.218', '37.116.187.212', '127.0.0.1', '::1'),
    ),
));
$config->addSessionComponent(24 * 60 * 60, 'YiiSessions');
$config->addStandardComponents(array(
    'urlManager.class' => 'application.components.framework.UrlManager',
));
$config->addStandardImports(array(
    'comp.user.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',
    'application.vendors.phpexcel.PHPExcel',
));

return $config->getConfig();
