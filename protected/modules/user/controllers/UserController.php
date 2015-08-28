<?php

class UserController extends Controller {

    public function accessRules() {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('logout'),
            ),
            array('allow',
                'users' => array('*'),
            ),
        );
    }

    public function filters() {
        return array('accessControl');
    }

    public function init() {
        $this->layout = null; # forzo l'utilizzo del layout applicazione
    }

    public function actionLogin() {
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') :
            echo CActiveForm::validate($model);
            Yii::app()->end();
        endif;
        if (isset($_POST['LoginForm'])) :
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        endif;
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Login::UpdateLogin();
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionHashPassword() {
        CVarDumper::dump(PasswordHelper::hashPassword($_GET['password']), 10, true);
    }

}
