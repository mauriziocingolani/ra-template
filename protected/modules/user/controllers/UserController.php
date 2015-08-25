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
                'RoleID' => Role::ROLE_OPERATORE,
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
//            array('Fava', 'Lucia', 'l.fava@ggfgroup.it'),
//            array('Osmani', 'Laura', 'l.osmani@ggfgroup.it'),
//            array('Bartolomei', 'Chiara', 'c.bartolomei@ggfgroup.it'),
//            array('Chiarappa', 'Danilo', 'd.chiarappa@ggfgroup.it'),
//            array('Torretti', 'Sabrina', 's.torretti@ggfgroup.it'),
            array('operatorex', 'Sabrina', null),
        );
        foreach ($users1 as $u) :
            try {
                $user = new User;
                $password = substr(md5(time()), 0, 12);
                $user->setAttributes(array(
                    'RoleID' => Role::ROLE_OPERATORE,
                    'UserName' => strtolower(preg_replace('/[^a.-zA-Z]/', '', $u[0])),
                    'FirstName' => $u[1],
                    'LastName' => $u[0],
                    'Password' => CPasswordHelper::hashPassword($password),
                    'Email' => $u[2] ? $u[2] : null,
                    'Enabled' => 1,
                        ), false);
                CVarDumper::dump($user->save(), 10, true);
                CVarDumper::dump($user->UserName, 10, true);
                CVarDumper::dump($password, 10, true);
//                CVarDumper::dump(CPasswordHelper::hashPassword($password), 10, true);
            } catch (CDbException $e) {
                CVarDumper::dump($e->getMessage(), 10, true);
            }
        endforeach;
    }

}
