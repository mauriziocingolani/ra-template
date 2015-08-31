<?php

class CampaignsController extends TemplateController {

    public function accessRules() {
        return array(
            array('deny',
                'expression' => '!Yii::app()->user->isSupervisor(true)',
            ),
        );
    }

    public function actionIndex() {
        $model = new Campaign('search');
        $user = new User('search');
        $model->unsetAttributes();
        $user->unsetAttributes();
        if (isset($_GET['Campaign']))
            $model->attributes = $_GET['Campaign'];
        if (isset($_GET['User']))
            $user->attributes = $_GET['User'];
        $model->searchUser = $user;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCampaign($campaignid = null) {
        if ($campaignid) :
            $model = Campaign::model()->findByPk($campaignid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('La campagna', true);
            endif;
        else :
            $model = new Campaign;
        endif;
        If (Yii::app()->request->isPostRequest) :
            if (isset($_POST['Campaign'])) :
                $model->setAttributes($_POST['Campaign']);
                try {
                    if ($model->save()) :
                        Yii::app()->user->setFlash('success', 'Campagna ' . ($campaignid ? 'modificata' : 'creata') . '!');
                        if ($campaignid) :
                            $this->refresh();
                        else :
                            $this->redirect(array('/campagna/' . (int) Yii::app()->db->lastInsertID));
                        endif;
                    endif;
                } catch (CDbException $e) {
                    if ($e->errorInfo[1] == 1062) :
                        Yii::app()->user->setFlash('error', 'Violazione vincolo di unicità: una campagna con questo nome esiste già.');
                    else :
                        Yii::app()->user->setFlash('error', $e->getMessage());
                    endif;
                }
            elseif (isset($_POST['CampaignOperators'])) :
                try {
                    $model->setOperators($_POST['CampaignOperators']);
                    Yii::app()->user->setFlash('operators_success', 'Lista operatori aggiornata!');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('operators_error', $e->getMessage());
                    return $e;
                }
            endif;
        endif;
        $this->render('campaign', array(
            'model' => $model,
            'operators' => User::GetOperatori(),
        ));
    }

    public function actionDelete($id) {
        $model = Campaign::model()->findByPk($id);
        try {
            $model->delete();
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451)
                echo "<div class='flash-error'>La campagna <strong>" . CHtml::encode($model->Name) .
                "</strong> &egrave; gi&agrave; stata lavorata e non pu&ograve; essere eliminata.</div>";
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionStats() {
        $campaigns = Campaign::GetAll();
        $data = array();
        foreach ($campaigns as $camp) :
            $data[] = array('campaign' => $camp, 'stats' => $camp->statistiche);
        endforeach;
        $this->render('stats', array(
            'data' => $data,
        ));
    }

}
