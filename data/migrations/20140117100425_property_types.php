<?php

use Phinx\Migration\AbstractMigration;

class PropertyTypes extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $entityTypes = $this->table('property_types');
        $entityTypes
            ->addColumn('name', 'string', array('limit' => 35)) // eg String
            ->addColumn('slug', 'string', array('limit' => 35)) // unique
            ->save();

        $this->execute("INSERT INTO `entity_types` (`name`, `slug` VALUES ('String', 'string', 1, 1)");
        $this->execute("INSERT INTO `entity_types` (`name`, `slug` VALUES ('String', 'string', 1, 1)");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}