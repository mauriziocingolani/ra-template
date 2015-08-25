<?php

class m150825_120852_create_users_tables extends CDbMigration {

    public function safeUp() {
        # roles
        $this->createTable('roles', array(
            'RoleID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Description' => 'varchar(50) COLLATE latin1_general_ci NOT NULL',
            'PRIMARY KEY (RoleID)',
            'UNIQUE KEY unique_roles_description (Description)',
                ), 'ENGINE=InnoDB CHARSET=latin1');
        $this->insertMultiple('roles', array(
            array('Description' => 'Developer'),
            array('Description' => 'Supervisor'),
            array('Description' => 'Operatore'),
        ));
        # utenti
        $this->createTable('users', array(
            'UserID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'RoleID' => 'int(11) unsigned NOT NULL',
            'UserName' => 'varchar(255) COLLATE latin1_general_ci NOT NULL',
            'FirstName' => 'varchar(255) COLLATE latin1_general_ci NOT NULL',
            'LastName' => 'varchar(255) COLLATE latin1_general_ci NOT NULL',
            'Gender' => 'enum(\'M\',\'F\') COLLATE latin1_general_ci NOT NULL DEFAULT \'M\'',
            'Password' => 'char(60) COLLATE latin1_general_ci NOT NULL',
            'Email' => 'varchar(255) COLLATE latin1_general_ci DEFAULT NULL',
            'Enabled' => 'tinyint(1) NOT NULL',
            'PRIMARY KEY (UserID)',
            'UNIQUE KEY unique_users_username (UserName)',
            'KEY RoleID (RoleID)',
                ), 'ENGINE=InnoDB CHARSET=latin1');
        $this->addForeignKey('fk_users_roles', 'users', 'RoleID', 'roles', 'RoleID');
        $this->insert('users', array(
            'RoleID' => 1,
            'UserName' => Yii::app()->params['admin']['username'],
            'FirstName' => 'Maurizio',
            'LastName' => 'Cingolani',
            'Gender' => 'M',
            'Password' => CPasswordHelper::hashPassword(Yii::app()->params['admin']['password']),
            'Email' => 'm.cingolani@ggfgroup.it',
            'Enabled' => 1,
        ));
        # logins 
        $this->createTable('logins', array(
            'LoginID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'SessionID' => 'char(32) NOT NULL',
            'UserID' => 'int(11) unsigned DEFAULT NULL',
            'UserName' => 'varchar(255) DEFAULT NULL',
            'Login' => 'datetime DEFAULT NULL',
            'Logout' => 'datetime DEFAULT NULL',
            'IpAddress' => 'varchar(15) DEFAULT NULL',
            'PRIMARY KEY (LoginID)',
            'KEY UserID (UserID)',
                ), 'ENGINE=InnoDB CHARSET=latin1');
        $this->addForeignKey('fk_logins_users', 'logins', 'UserID', 'users', 'UserID');
    }

    public function safeDown() {
        $this->dropTable('logins');
        $this->dropTable('users');
        $this->dropTable('roles');
    }

}
