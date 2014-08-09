<?php

use Phinx\Migration\AbstractMigration;

class MediaFolders extends AbstractMigration
{
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $mediaFolders = $this->table('media_folders');
        $mediaFolders->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('parent', 'integer', ['limit' => 2])
              ->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('media_folders');
    }
}