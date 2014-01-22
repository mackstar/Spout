<?php

use Phinx\Migration\AbstractMigration;

class FieldValuesString extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_string');
        $table
            ->addColumn('resource_id', 'integer', array('limit' => 10))
            ->addColumn('resource_property_id', 'integer', array('limit' => 10))
            ->addColumn('value', 'string', array('limit' => 255))
            ->addIndex(array('resource_id'), array('unique' => false))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_string');
    }
}