<?php

use Phinx\Migration\AbstractMigration;

class AddBooleanFieldType extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('field_values_boolean');
        $table
            ->addColumn('resource_id', 'integer', ['limit' => 10])
            ->addColumn('resource_field_id', 'integer', ['limit' => 10])
            ->addColumn('value', 'integer', ['limit' => 1])
            ->addIndex(['resource_id'])
            ->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('field_values_boolean');
    }
}