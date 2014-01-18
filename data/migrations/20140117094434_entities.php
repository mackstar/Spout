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
            ->addColumn('type', 'string', array('limit' => 25))
            ->addColumn('meta_keywords', 'string', array('limit' => 255))
            ->addColumn('meta_title', 'string', array('limit' => 255))
            ->addColumn('meta_description', 'string', array('limit' => 255))
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