<?php

use Phinx\Migration\AbstractMigration;

class FieldOptions extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('property_type_options');
        $table
            ->addColumn('property_type', 'string', array('limit' => 35)) // slug eg image
            ->addColumn('key', 'string', array('limit' => 35)) // eg path
            ->addColumn('value', 'string', array('limit' => 35)) // eg items
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('property_type_options');
    }
}