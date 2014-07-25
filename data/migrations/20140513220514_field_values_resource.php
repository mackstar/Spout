<?php

use Phinx\Migration\AbstractMigration;

class FieldValuesResource extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_resource');
        $table
            ->addColumn('resource_id', 'integer', ['limit' => 10])
            ->addColumn('resource_field_id', 'integer', ['limit' => 10])
            ->addColumn('type', 'string', ['limit' => 20])
            ->addColumn('slug', 'string', ['limit' => 50])
            ->addIndex(['resource_id'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_resource');
    }
}