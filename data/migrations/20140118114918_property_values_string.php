<?php

use Phinx\Migration\AbstractMigration;

class PropertyValuesString extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('property_values_string');
        $table
            ->addColumn('entity_id', 'int', array('limit' => 10))
            ->addColumn('entity_property_id', 'int', array('limit' => 10))
            ->addColumn('value', 'string', array('limit' => 255))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('property_values_string');
    }
}