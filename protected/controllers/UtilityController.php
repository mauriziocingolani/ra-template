<?php

class UtilityController extends TemplateController {

    const DEBUG = false;

    public function accessRules() {
        return array(
            array('deny',
                'expression' => '!Yii::app()->user->isDeveloper()',
            ),
        );
    }

    public function actionClean() {
        $model = new UtilityCleanDbForm;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['UtilityCleanDbForm']);
            if ($model->validate()) :
                try {
                    $transaction = Yii::app()->db->beginTransaction();
                    Activity::model()->deleteAll();
                    Script1a0f3f9Test::model()->deleteAll();
                    CampaignCompany::model()->deleteAll();
                    UserCampaign::model()->deleteAll();
                    Campaign::model()->deleteAll();
                    CompanyAddress::model()->deleteAll();
                    CompanyPhone::model()->deleteAll();
                    CompanyEmail::model()->deleteAll();
                    CompanyContact::model()->deleteAll();
                    Company::model()->deleteAll();
                    self::DEBUG ? $transaction->rollback() : $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Il database &egrave; stato ripulito.');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            endif;
        endif;
        $this->render('clean', array(
            'model' => $model,
        ));
    }

    public function actionCreateUser() {
        $model = new User;
        if (Yii::app()->getRequest()->isPostRequest) :
            $model->setAttributes($_POST['User'], true);
            $result = $model->saveModel();
            if ($result === true) :
                Yii::app()->user->setFlash('success', 'Utente creato! Le credenziali di accesso sono state inviate per email.');
            else :
                Yii::app()->user->setFlash('error', "Impossibile creare il novo utente. Il server riporta:<br /><br /><em>$result</em>");
            endif;
        endif;
        $this->render('createUser', array(
            'model' => $model,
        ));
    }

}
