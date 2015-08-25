<?php

/**
 * This is the model class for table "logins".
 *
 * The followings are the available columns in table 'logins':
 * @property integer $LoginID
 * @property integer $SessionID
 * @property integer $UserID
 * @property string $UserName
 * @property string $Login
 * @property string $Logout
 * @property string $IpAddress
 */
class Login extends CActiveRecord {

    public function tableName() {
        return 'logins';
    }

    public function relations() {
        return array(
            'User' => array(self::BELONGS_TO, 'User', 'UserID')
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function CreateLogin($user) {
        $login = new Login;
        $login->SessionID = Yii::app()->session->getSessionID();
        if ($user instanceof User) :
            $login->UserID = $user->UserID;
        else :
            $login->UserName = $user;
        endif;
        $login->Login = date('Y-m-d H:i:s');
        $login->IpAddress = Yii::app()->request->userHostAddress;
        $login->save();
    }

    public static function UpdateLogin() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'UserID=:userid AND SessionID=:sessionid AND Logout IS NULL';
        $criteria->params = array(':userid' => Yii::app()->user->getId(), 'sessionid' => Yii::app()->session->getSessionID());
        $criteria->limit = 1;
        $login = self::model()->find($criteria);
        if ($login) :
            $login->Logout = date('Y-m-d H:i:s');
            $login->save();
        endif;
    }

}
