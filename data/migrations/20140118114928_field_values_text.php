<?php

use Phinx\Migration\AbstractMigration;

class FieldValuesText extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_text');
        $table
            ->addColumn('resource_id', 'integer', array('limit' => 10))
            ->addColumn('resource_property_id', 'integer', array('limit' => 10))
            ->addColumn('value', 'text')
            ->addIndex(array('resource_id'), array('unique' => false))
            ->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_text');
    }
}