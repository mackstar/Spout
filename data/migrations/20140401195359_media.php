<?php

use Phinx\Migration\AbstractMigration;

class Media extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $roles = $this->table('media');
        $roles->addColumn('title', 'string', array('limit' => 30))
            ->addColumn('slug', 'integer', array('limit' => 2))
            ->addColumn('suffix', 'integer', array('limit' => 2))
            ->addColumn('type', 'string', array('limit' => 30))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('media');
    }
}