<?php

class m150915_061939_alter_users_tables extends DbMigration {

    public function up() {
        $this->addColumn('users', 'NewPassword', 'text AFTER Password');
    }

    public function down() {
        $this->dropColumn('users', 'NewPassword');
    }

}
