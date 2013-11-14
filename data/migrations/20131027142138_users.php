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
        $users->addColumn('name', 'string', array('limit' => 100))
              ->addColumn('email', 'string', array('limit' => 30))
              ->addColumn('password', 'string', array('limit' => 60))
              ->addIndex(array('email'), array('unique' => true))
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