<?php

use Phinx\Migration\AbstractMigration;

class media extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $roles = $this->table('media');
        $roles->addColumn('uuid', 'string', array('limit' => 36))
            ->addColumn('title', 'string', array('limit' => 30, 'default' => null, 'null' => true))
            ->addColumn('directory', 'string', array('limit' => 2))
            ->addColumn('file', 'string', array('limit' => 150))
            ->addColumn('suffix', 'string', array('limit' => 5))
            ->addColumn('type', 'string', array('limit' => 10))
            ->addIndex(array('uuid'), array('unique' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('media');
    }
}
