<?php

class m150825_120852_create_users_tables extends DbMigration {

    public function safeUp() {
        # roles
        $this->createTable('roles', array(
            'RoleID' => self::Pk(),
            'Description' => self::TypeVarchar(50, true),
            self::Pk('RoleID'),
            'UNIQUE KEY unique_roles_description (Description)',
                ), self::TableOptions());
        $this->insertMultiple('roles', array(
            array('Description' => 'Developer'),
            array('Description' => 'Supervisor'),
            array('Description' => 'Operatore'),
        ));
        # utenti
        $this->createTable('users', array(
            'UserID' => self::Pk(),
            'RoleID' => self::TypeInt(true),
            'UserName' => self::TypeVarchar(255, true),
            'FirstName' => self::TypeVarchar(255, true),
            'LastName' => self::TypeVarchar(255, true),
            'Gender' => 'enum(\'M\',\'F\') COLLATE latin1_general_ci NOT NULL DEFAULT \'M\'',
            'Password' => 'text NOT NULL',
            'Email' => self::TypeVarchar(255),
            'Enabled' => 'tinyint(1) NOT NULL',
            self::Pk('UserID'),
            'UNIQUE KEY unique_users_username (UserName)',
            'KEY RoleID (RoleID)',
                ), self::TableOptions());
        $this->addForeignKey('fk_users_roles', 'users', 'RoleID', 'roles');
        $this->insert('users', array(
            'RoleID' => 1,
            'UserName' => Yii::app()->params['admin']['username'],
            'FirstName' => 'Maurizio',
            'LastName' => 'Cingolani',
            'Gender' => 'M',
            'Password' => CPasswordHelper::hashPassword(Yii::app()->params['admin']['password']),
            'Email' => Yii::app()->params['admin']['email'],
            'Enabled' => 1,
        ));
        # logins 
        $this->createTable('logins', array(
            'LoginID' => self::Pk(),
            'SessionID' => self::TypeChar(32, true),
            'UserID' => self::TypeInt(),
            'UserName' => self::TypeVarchar(255),
            'Login' => self::TypeDate(true),
            'Logout' => self::TypeDate(true),
            'IpAddress' => self::TypeVarchar(15),
            self::Pk('LoginID'),
            'KEY UserID (UserID)',
                ), self::TableOptions());
        $this->addForeignKey('fk_logins_users', 'logins', 'UserID', 'users');
    }

    public function safeDown() {
        $this->dropTable('logins');
        $this->dropTable('users');
        $this->dropTable('roles');
    }

}
