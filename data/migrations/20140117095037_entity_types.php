<?php

use Phinx\Migration\AbstractMigration;

class EntityTypes extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $entityTypes = $this->table('entity_types');
        $entityTypes
            ->addColumn('name', 'string', array('limit' => 35))
            ->addColumn('slug', 'string', array('limit' => 35))
            ->addColumn('categories', 'int', array('limit' => 1))
            ->addColumn('tags', 'int', array('limit' => 1))
            ->addColumn('meta_description', 'int', array('limit' => 1))
            ->addColumn('meta_keywords', 'int', array('limit' => 1))
            ->addColumn('meta_title', 'int', array('limit' => 1))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entities_types');
    }
}
