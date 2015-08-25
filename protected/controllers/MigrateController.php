<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MigrateController
 *
 * @author maurizio
 */
class MigrateController extends TemplateController {

    public function actionCreateMigration($name) {
        $this->runMigrationTool(array('create', $name));
    }

    public function actionMigrate($action) {
        $this->runMigrationTool(array($action));
    }

    private function runMigrationTool(array $command) {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
        $runner->addCommands($commandPath);
        $args = array_merge(array('yiic', 'migrate'), $command, array('--interactive=0','--migrationTable=YiiMigrations'));

        ob_start();
        $runner->run($args);
        echo htmlentities(ob_get_clean(), null, Yii::app()->charset);
    }

}
