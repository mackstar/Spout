<?php

use Phinx\Migration\AbstractMigration;

class IndexUris extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('index_uris');
        $table
            ->addColumn('index', 'string', ['limit' => 100])
            ->addColumn('uri', 'string', ['limit' => 255])
            ->addColumn('key', 'string', ['limit' => 255])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('index_uris');
    }
}