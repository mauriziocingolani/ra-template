<?php

class SiteController extends TemplateController {

    public function actionIndex() {
        $this->render('index', array(
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLicenza() {
        $this->render('license/it');
    }

    public function actionLicense() {
        $this->render('license/en');
    }

}
