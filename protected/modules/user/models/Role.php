<?php

/**
 * @property integer $RoleID
 * @property string $Description
 * @property User[] $users
 */
class Role extends CActiveRecord {

    public function relations() {
        return array(
            'users' => array(self::HAS_MANY, 'User', 'RoleID'),
        );
    }

    public function tableName() {
        return 'roles';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
    /* Metodi */
    /* Metodi statici */

    public static function GetAll() {
        return self::model()->findAll(array('order' => 'RoleID DESC'));
    }

    /* Ajax */
}
