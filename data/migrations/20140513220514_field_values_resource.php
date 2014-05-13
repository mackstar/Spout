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
            ->addColumn('resource_id', 'integer', array('limit' => 10))
            ->addColumn('resource_field_id', 'integer', array('limit' => 10))
            ->addColumn('type', 'string', array('limit' => 20))
            ->addColumn('slug', 'string', array('limit' => 50))
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