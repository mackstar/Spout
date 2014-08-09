<?php

use Phinx\Migration\AbstractMigration;

class AddFoldersToMedia extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $roles = $this->table('media');
        $roles->addColumn('folder', 'integer', ['limit' => 2])
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $roles = $this->table('media');
        $roles->removeColumn('folder')
              ->save();
    }
}