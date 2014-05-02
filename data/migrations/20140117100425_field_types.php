<?php

use Phinx\Migration\AbstractMigration;

class FieldTypes extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_types');
        $table
            ->addColumn('name', 'string', array('limit' => 35)) // eg String
            ->addColumn('slug', 'string', array('limit' => 35)) 
            ->addIndex(array('slug'), array('unique' => true))
            ->save();

        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('String', 'string')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Text', 'text')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Media', 'media')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Resource', 'resource')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Resource Index', 'index')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Date', 'date')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Time', 'time')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Date Time', 'datetime')");
        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('Boolean', 'boolean')");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_types');
    }
}