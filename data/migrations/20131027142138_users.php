<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
{


    /**
     * Migrate Up.
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 30])
              ->addColumn('password', 'string', ['limit' => 60])
              ->addColumn('role_id', 'integer', ['limit' => 2])
              ->addIndex(['email'], ['unique' => true])
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
