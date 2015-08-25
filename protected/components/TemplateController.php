<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateController
 *
 * @author maurizio
 */
class TemplateController extends Controller {

    public $layoutParams = array();
    public $menuHeader = 'Funzioni';
    public $crumbs;

    public function init() {
        parent::init();
        $this->pageTitle = Yii::app()->name;
    }

}
