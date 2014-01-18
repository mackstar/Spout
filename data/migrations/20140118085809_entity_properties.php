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
            ->addColumn('title_field', 'integer', array('limit' => 1))
            ->addColumn('multiple', 'integer', array('limit' => 1))
            ->addColumn('weight', 'integer', array('limit' => 10))
            ->addIndex(array('entity_type', 'slug'), array('unique' => true))
            ->save();

        $stub = "INSERT INTO `entity_properties` " .
            "(`entity_type`, `property_type`, `label`, `slug`, `multiple`, `weight`, `title_field`) VALUES ";

        $this->execute($stub . " ('blog', 'string', 'Title', 'title', 0, 1, 1)");
        $this->execute($stub . " ('blog', 'text', 'Body', 'body',  0, 2, 0)");
        $this->execute($stub . " ('blog', 'string', 'Meta Keywords', 'meta-keywords', 1, 3, 0)");
        $this->execute($stub . " ('blog', 'string', 'Meta Description', 'meta-description', 0, 3, 0)");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entity_properties');
    }
}