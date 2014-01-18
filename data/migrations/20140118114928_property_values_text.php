<?php

use Phinx\Migration\AbstractMigration;

class PropertyTypeText extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('property_values_text');
        $table
            ->addColumn('entity_id', 'int', array('limit' => 10))
            ->addColumn('entity_property_id', 'int', array('limit' => 10))
            ->addColumn('value', 'text')
            ->addIndex(array('entity_id', 'entity_property_id'), array('unique' => false))
            ->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('property_values_text');
    }
}