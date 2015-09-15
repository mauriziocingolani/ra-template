<?php

/**
 * @property User $_user
 */
class ForgottenPasswordForm extends CFormModel {

    public $username;
    private $_user;

    public function attributeLabels() {
        return array(
            'username' => 'Nome utente o indirizzo email',
        );
    }

    public function rules() {
        return array(
            array('username', 'required', 'message' => 'Inserisci il tuo nome utente oppure i tuo indirizzo email'),
            array('username', 'user', 'message' => 'Utente o indirizzo email non riconosciuti.'),
        );
    }

    /* Eventi */
    /* Metodi */

    public function user($attribute, $params) {
        $this->_user = User::GetUserByUsername($this->username, true);
        if (!$this->_user)
            $this->addError($attribute, $params['message']);
    }

    public function sendInstructions() {
        if ($this->_user) :
            if (!$this->_user->Email) :
                Yii::app()->user->setFlash('error', 'Impossibile eseguire il reset della password: per questo utente non &egrave; stato impostato l\'indirizzo email.');
                return false;
            endif;
            $newPassword = PasswordHelper::GeneratePassword(20);
            try {
                $this->_user->NewPassword = PasswordHelper::hashPassword($newPassword);
                $key = sha1($this->_user->UserID . $this->_user->NewPassword);
                if ($this->_user->save()) :
                    $message = new YiiMailMessage;
                    $message->view = 'newPassword';
                    $message->from = Yii::app()->params['webadmin'];
                    $message->subject = Yii::app()->name . ' - Nuova password';
                    $message->setBody(array('user' => $this->_user, 'newPassword' => $newPassword, 'key' => $key), 'text/html');
                    $message->setTo($this->_user->Email);
                    $message->setCc(Yii::app()->params['admin']['email']);
                    if (!Yii::app()->mail->send($message)) :
                        Yii::app()->user->setFlash('error', 'Si &egrave; verificato un errore. Impossibile inviare il messaggio email con la nuova password.');
                        return false;
                    endif;
                    return true;
                else :
                    Yii::app()->user->setFlash('error', 'Si &egrave; verificato un errore. Impossibile eseguire il reset della password.');
                    return false;
                endif;
            } catch (CDbException $e) {
                
            }
        endif;
        Yii::app()->user->setFlash('error', 'Si &egrave; verificato un errore. Impossibile eseguire il reset della password.');
        return false;
    }

    /* Metodi statici */
    /* Ajax */
}
