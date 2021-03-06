<?php

class LoginForm extends CFormModel {

    public $username;
    public $password;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, password', 'required', 'message' => 'Questo campo &egrave; obbligatorio'),
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => 'Nome utente',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate())
                $this->addError('password', 'Nome utente o password non validi.');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) :
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        endif;
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) :
            Yii::app()->user->login($this->_identity);
            Login::CreateLogin(Yii::app()->user->user);
            return true;
        endif;
        return false;
    }

}
