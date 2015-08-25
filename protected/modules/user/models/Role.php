<?php

/**
 * @property integer $RoleID
 * @property string $Description
 * @property User[] $users
 */
class Role extends CActiveRecord {

    const ROLE_DEVELOPER = 1;
    const ROLE_SUPERVISOR = 2;
    const ROLE_OPERATORE = 3;

    public function tableName() {
        return 'roles';
    }

    public function relations() {
        return array(
            'users' => array(self::HAS_MANY, 'User', 'RoleID'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
