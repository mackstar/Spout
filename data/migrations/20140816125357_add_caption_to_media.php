<?php

use Phinx\Migration\AbstractMigration;

class AddCaptionToMedia extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('media');
        $table
            ->addColumn('caption', 'text', ['default' => null, 'null' => true])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('media');
        $table
            ->removeColumn('caption')
            ->save();
    }
}