<?php

use Phinx\Migration\AbstractMigration;

class PropertyTypes extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('property_types');
        $table
            ->addColumn('name', 'string', array('limit' => 35)) // eg String
            ->addColumn('slug', 'string', array('limit' => 35)) // unique
            ->save();

        $this->execute("INSERT INTO `property_types` (`name`, `slug`) VALUES ('String', 'string')");
        $this->execute("INSERT INTO `property_types` (`name`, `slug`) VALUES ('Text', 'text')");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('property_types');
    }
}