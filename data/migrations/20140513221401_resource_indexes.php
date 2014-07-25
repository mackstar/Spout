<?php

use Phinx\Migration\AbstractMigration;

class ResourceIndexes extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resource_indexes');
        $table
            ->addColumn('uuid', 'string', ['limit' => 36])
            ->addColumn('resource_type', 'string', ['limit' => 20])
            ->addColumn('resource_field_key', 'string', ['limit' => 10])
            ->addColumn('resource_field_value', 'string', ['limit' => 20])
            ->addColumn('limit', 'integer', ['limit' => 3])
            ->addColumn('order', 'string', ['limit' => 4])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('resource_indexes');
    }
}