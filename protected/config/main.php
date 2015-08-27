<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/protected/components/framework/Config.php';
$config = new Config('Remote Account - Template', 'files');
$config->addAlias(array(
    'comp' => 'application.components',
    'modules' => 'application.modules',
    'widgets' => 'application.components.widgets',
));
$config->addComponent(array(
    'cache' => array(
        'class' => 'system.caching.CDbCache',
        'connectionID' => 'db',
    ),
    'twitter' => require(dirname(__FILE__) . '/files/twitter.php'),
    'user' => array(
        'class' => 'comp.ApplicationWebUser',
        'allowAutoLogin' => false,
        'loginUrl' => array('login'),
    ),
));
$config->addDbComponent();
$config->addMailComponent();
$config->addModule(array(
    'user',
    'gii' => require(dirname(__FILE__) . '/files/gii.php'),
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
    'ext.yii-mail.YiiMailMessage',
));

return $config->getConfig();
