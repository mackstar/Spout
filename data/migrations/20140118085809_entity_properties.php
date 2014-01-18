<?php

use Phinx\Migration\AbstractMigration;

class EntityProperties extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('entity_properties');
        $table
            ->addColumn('entity_type', 'string', array('limit' => 35))
            ->addColumn('property_type', 'string', array('limit' => 35))
            ->addColumn('label', 'string', array('limit' => 35))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}