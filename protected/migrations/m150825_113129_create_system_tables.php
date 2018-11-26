<?php

class m150825_113129_create_system_tables extends DbMigration {

    public function safeUp() {
        $this->createTable('YiiCache', array(
            'id' => 'char(128) NOT NULL',
            'expire' => 'int(11)',
            'value' => 'longblob',
            'PRIMARY KEY (id)',
                ), 'ENGINE=MyISAM CHARSET=utf8'
        );
        $this->createTable('YiiSessions', array(
            'id' => 'char(32) NOT NULL',
            'expire' => 'int(11) NOT NULL',
            'data' => 'blob NOT NULL',
            'PRIMARY KEY (id)',
            'KEY sessions_expire (expire)',
                ), 'ENGINE=MyISAM CHARSET=utf8'
        );
        $this->createTable('YiiTweets', array(
            'id' => 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'id_str' => 'varchar(255) NOT NULL',
            'created' => 'datetime NOT NULL',
            'text' => 'text NOT NULL',
            'PRIMARY KEY (id)',
            'UNIQUE KEY unique_tweets_idstr (id_str)',
                ), 'ENGINE=MyISAM CHARSET=utf8'
        );
    }

    public function safeDown() {
        $this->dropTable('YiiCache');
        $this->dropTable('YiiSessions');
    }

}
