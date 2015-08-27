<?php

class UserController extends Controller {

    public function accessRules() {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('logout'),
            ),
            array('deny',
                'actions' => array('createUser', 'createUsers'),
                'expression' => '!Yii::app()->user->isDeveloper()',
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

    public function actionCreateUser() {
        try {
            $user = new User;
            $password = 'gatt8484VANI@';
//            $password=  substr(md5(time()), 0,10);
            $user->setAttributes(array(
                'RoleID' => ApplicationWebUser::ROLE_OPERATORE,
                'UserName' => 'operatore4',
                'FirstName' => 'Vanina',
                'LastName' => 'Gatti',
                'Password' => CPasswordHelper::hashPassword($password),
                'Email' => null,
                'Enabled' => 1,
                    ), false);
            CVarDumper::dump($user->save(), 10, true);
            CVarDumper::dump($password, 10, true);
            CVarDumper::dump(CPasswordHelper::hashPassword($password), 10, true);
        } catch (CDbException $e) {
            CVarDumper::dump($e->getMessage(), 10, true);
        }
    }

    public function actionCreateUsers() {
        $users1 = array(
            array('Fava', 'Lucia', 'fava', 'l.fava@ggfgroup.it', ApplicationWebUser::ROLE_SUPERVISOR),
        );
        foreach ($users1 as $u) :
            try {
                $user = new User;
                $password = PasswordHelper::GeneratePassword(16);
                $user->setAttributes(array(
                    'RoleID' => $u[4],
                    'UserName' => $u[2],
                    'FirstName' => $u[1],
                    'LastName' => $u[0],
                    'Password' => CPasswordHelper::hashPassword($password),
                    'Email' => $u[3] ? $u[3] : null,
                    'Enabled' => 1,
                        ), false);
                if ($user->save() && $u[3]) :
                    $message = new YiiMailMessage;
                    $message->view = 'account';
                    $message->from = 'webmaster@remoteaccount.it';
                    $message->subject = 'Remote Account Template - Account gestionale';
                    $message->setBody(array('username' => $user->UserName, 'password' => $password), 'text/html');
                    $message->setTo($user->Email);
                    $message->setCc('m.cingolani@ggfgroup.it');
                    CVarDumper::dump(Yii::app()->mail->send($message), 10, true);
                endif;
            } catch (CDbException $e) {
                CVarDumper::dump($e->getMessage(), 10, true);
            }
        endforeach;
    }

}
