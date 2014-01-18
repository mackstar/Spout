<?php

use Phinx\Migration\AbstractMigration;

class Fields extends AbstractMigration
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
            ->addColumn('required', 'int', array('limit' => 1)) // boolean
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}