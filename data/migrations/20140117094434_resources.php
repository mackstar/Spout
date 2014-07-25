<?php

use Phinx\Migration\AbstractMigration;

class Resources extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resources');
        $table
            ->addColumn('slug', 'string', ['limit' => 35])
            ->addColumn('type', 'string', ['limit' => 25])
            ->addColumn('title', 'string', ['limit' => 255])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('resources');
    }
}
