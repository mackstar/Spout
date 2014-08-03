<?php

use Phinx\Migration\AbstractMigration;

class Indexes extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('indexes');
        $table
            ->addColumn('slug', 'string', ['limit' => 100])
            ->addColumn('title', 'string', ['limit' => 100])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('indexes');
    }
}