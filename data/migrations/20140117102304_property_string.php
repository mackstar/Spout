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
            ->addColumn('slug', 'string', array('limit' => 35)) // eg string
            ->addColumn('options', 'text') // A serialized list
            ->save();

        $this->execute("INSERT INTO `field_types` (`name`, `slug`) VALUES ('String', 'string')");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}