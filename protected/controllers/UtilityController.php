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

    public function actionCleanCache() {
        try {
            $command = Yii::app()->db->createCommand("DELETE FROM YiiCache")->execute();
            Yii::app()->user->setFlash('success', 'Cache ripulita!');
        } catch (CDbException $e) {
            Yii::app()->user->setFlash('error', 'Impossibile ripulire la cache. Il server riporta: ' . $e->getMessage());
        }
        $this->render('cleanCache');
    }

    public function actionUsers() {
        $user = new User('search');
        $user->unsetAttributes();
        if (isset($_GET['User']))
            $user->attributes = $_GET['User'];
        $this->render('users', array('user' => $user));
    }

    public function actionUser($userid = null) {
        if ($userid) :
            $model = User::model()->findByPk($userid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('L\'utente', false);
            endif;
        else :
            $model = new User;
        endif;
        if (Yii::app()->getRequest()->isPostRequest) :
            $model->setAttributes($_POST['User'], true);
            $result = $model->saveModel();
            if ($result === true) :
                Yii::app()->user->setFlash('success', $userid ? 'Utente modificato' : 'Utente creato! Le credenziali di accesso sono state inviate per email.');
            else :
                Yii::app()->user->setFlash('error', "Impossibile " . ($userid ? 'aggiornare' : 'creare') . " il novo utente. Il server riporta:<br /><br /><em>$result</em>");
            endif;
            return $this->redirect('/utility/gestione-utente/' . $model->UserID);
        endif;
        $this->render('user', array('model' => $model));
    }

    public function actionDelete($id) {
        $model = User::model()->findByPk($id);
        try {
            $model->delete();
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451)
                echo "<div class='flash-error'>L'\utente <strong>" . CHtml::encode($model->UserName) .
                "</strong> &egrave; gi&agrave; stato utilizzato e non pu&ograve; essere eliminato.</div>";
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

}
