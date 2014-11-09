<?php

use Phinx\Migration\AbstractMigration;

class AddCategoriesToResource extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resources');
        $table->addColumn('category_id', 'integer', ['limit' => 10])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('resources');
        $table->removeColumn('category_id')
            ->save();
    }
}