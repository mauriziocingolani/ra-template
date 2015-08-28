<?php

class ReportsController extends TemplateController {

    public function accessRules() {
        return array(
            array('deny',
                'expression' => '!Yii::app()->user->isSupervisor(true)',
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCampaigns() {
        $model = new ReportsCampaignsForm;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['ReportsCampaignsForm']);
            if ($model->validate()) :
                $result = Campaign::ReportCampaign($_POST['ReportsCampaignsForm']);
                if ($result === true) :
                    Yii::app()->user->setFlash('success', 'Report generato correttamente. Clicca <a href="/files/reports/report_campagna.xlsx" style="text-decoration: underline;">qui</a> per scaricare il file.');
                else :
                    Yii::app()->user->setFlash('error', 'Impossibile generare il report.' . (YII_DEBUG ? ' Il server riporta: <p>' . $result . '</p>' : ''));
                endif;
            endif;
        endif;
        $this->render('campaigns', array(
            'campaigns' => Campaign::GetAll(),
            'model' => $model,
        ));
    }

}
