<?php

class m150825_113129_create_system_tables extends CDbMigration {

    public function safeUp() {
        $this->createTable('YiiSessions', array(
            'id' => 'char(32) NOT NULL',
            'expire' => 'int(11) NOT NULL',
            'data' => 'blob NOT NULL',
            'PRIMARY KEY (id)',
            'KEY sessions_expire (expire)',
                ), 'ENGINE=MyISAM CHARSET=utf8'
        );
    }

    public function safeDown() {
        $this->dropTable('YiiSessions');
    }

}
