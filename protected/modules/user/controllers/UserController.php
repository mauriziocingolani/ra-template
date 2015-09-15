<?php

class UserController extends Controller {

    public function accessRules() {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('logout'),
            ),
            array('deny',
                'users' => array('@'),
                'actions' => array('forgottenPassword', 'resetPassword'),
                'message' => 'Questa operazione non è consentita agli utenti già loggati.',
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

    public function actionForgottenPassword() {
        $model = new ForgottenPasswordForm;
        if (Yii::app()->getRequest()->isPostRequest) :
            $model->setAttributes(Yii::app()->getRequest()->getPost('ForgottenPasswordForm'));
            if ($model->validate()) :
                $result = $model->sendInstructions();
                if ($result === true) :
                    Yii::app()->user->setFlash('success', true);
                    $this->refresh();
                endif;
            endif;
        endif;
        $this->render('forgottenPassword', array(
            'model' => $model,
        ));
    }

    public function actionResetPassword($key) {
        $error = null;
        $user = User::FindUserByKey($key);
        if ($user) :
            $error = $user->resetPassword();
        else :
            $error = true;
        endif;
        $this->render('resetPassword', array(
            'error' => $error,
        ));
    }

    public function actionHashPassword() {
        CVarDumper::dump(PasswordHelper::hashPassword($_GET['password']), 10, true);
    }

}
