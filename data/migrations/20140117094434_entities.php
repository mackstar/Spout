<?php

use Phinx\Migration\AbstractMigration;

class Entities extends AbstractMigration
{   
    /**
     * Migrate Up.
     */
    public function up()
    {
        $entities = $this->table('entities');
        $entities
            ->addColumn('slug', 'string', array('limit' => 35))
            ->addColumn('type', 'string', array('limit' => 25))
            ->addColumn('title', 'string', array('limit' => 255))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entities');
    }
}