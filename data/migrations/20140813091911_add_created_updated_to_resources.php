<?php

use Phinx\Migration\AbstractMigration;

class AddCreatedUpdatedToResources extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resources');
        $table
            ->addColumn('user_id', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime')
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('resources');
        $table
            ->removeColumn('user_id')
            ->removeColumn('created')
            ->removeColumn('updated')
            ->save();

    }
}