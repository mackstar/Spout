<?php

use Phinx\Migration\AbstractMigration;

class Links extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('links');
        $table
            ->addColumn('name', 'string', array('limit' => 35))
            ->addColumn('url', 'string', array('limit' => 100))
            ->addColumn('resource', 'string', array('limit' => 35)) // Slug
            ->addColumn('resource_type', 'string', array('limit' => 35)) // Resource type slug
            ->addColumn('weight', 'integer', array('limit' => 3))
            ->addColumn('depth', 'integer', array('limit' => 2))
            ->addColumn('parent_id', 'integer', array('limit' => 3))
            ->addColumn('menu', 'string', array('limit' => 35)) // Menu Slug
            ->addColumn('lft', 'string', array('limit' => 3))
            ->addColumn('rgt', 'string', array('limit' => 3))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('links');
    }
}