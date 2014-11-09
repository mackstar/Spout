<?php

use Phinx\Migration\AbstractMigration;

class AddResourceTagsTable extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resource_tags', ['id' => false, 'primary_key' => ['tag_id', 'resource_id']]);
        $table->addColumn('tag_id', 'integer', ['limit' => 10]);
        $table->addColumn('resource_id', 'integer', ['limit' => 10])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('resource_tags');
    }
}