<?php

use Phinx\Migration\AbstractMigration;

class FieldOptions extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_options');
        $table
            ->addColumn('property_type', 'string', array('limit' => 35)) // slug eg image
            ->addColumn('key', 'string', array('limit' => 35)) // 
            ->addColumn('value', 'string', array('limit' => 35)) // The field slug
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}