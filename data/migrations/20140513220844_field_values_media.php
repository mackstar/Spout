<?php

use Phinx\Migration\AbstractMigration;

class FieldValuesMedia extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_media');
        $table
            ->addColumn('resource_id', 'integer', array('limit' => 10))
            ->addColumn('resource_field_id', 'integer', array('limit' => 10))
            ->addColumn('uuid', 'string', array('limit' => 36))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_media');
    }
}