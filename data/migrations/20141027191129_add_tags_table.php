<?php

use Phinx\Migration\AbstractMigration;

class AddTagsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('tags');
        $table->addColumn('name', 'string', ['limit' => 100]);
        $table->addColumn('slug', 'string', ['limit' => 100])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('tags');
    }
}