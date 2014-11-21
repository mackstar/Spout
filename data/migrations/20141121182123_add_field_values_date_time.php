<?php

use Phinx\Migration\AbstractMigration;

class AddFieldValuesDateTime extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_datetime');
        $table
            ->addColumn('resource_id', 'integer', ['limit' => 10])
            ->addColumn('resource_field_id', 'integer', ['limit' => 10])
            ->addColumn('value', 'datetime')
            ->addIndex(['resource_id'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_datetime');
    }
}