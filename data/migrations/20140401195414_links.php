<?php

use Phinx\Migration\AbstractMigration;

class links extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('links');
        $table
            ->addColumn('name', 'string', ['limit' => 35])
            ->addColumn('url', 'string', ['limit' => 100, 'default' => null, 'null' => true])
            ->addColumn('type', 'string', ['limit' => 8])
            ->addColumn('resource', 'string', ['limit' => 35, 'default' => null, 'null' => true])
            ->addColumn('resource_type', 'string', ['limit' => 35, 'default' => null, 'null' => true])
            ->addColumn('weight', 'integer', ['limit' => 3])
            ->addColumn('depth', 'integer', ['limit' => 2, 'default' => null, 'null' => true])
            ->addColumn('parent_id', 'integer', ['limit' => 3])
            ->addColumn('menu', 'string', ['limit' => 35])
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
