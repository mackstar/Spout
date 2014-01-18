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
            ->addColumn('slug', 'string', array('limit' => 35))
            ->addColumn('multiple', 'int', array('limit' => 1))
            ->addColumn('weight', 'int', array('limit' => 10))
            ->save();

        $stub = "INSERT INTO `entity_properties` " .
            "(`entity_type`, `property_type`, `label`, `slug`, `multiple`, `weight`) VALUES ";

        $this->execute($stub . " ('blog', 'string', 'Title', 'title', 0, 1)");
        $this->execute($stub . " ('blog', 'text', 'Body', 'body',  0, 2)");
        $this->execute($stub . " ('blog', 'string', 'Meta Keywords', 1, 3)");
        $this->execute($stub . " ('blog', 'string', 'Meta Description', 1, 3)");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entity_properties');
    }
    }
}