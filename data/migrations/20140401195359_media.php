<?php

use Phinx\Migration\AbstractMigration;

class Media extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $roles = $this->table('media');
        $roles->addColumn('uuid', 'string', ['limit' => 36])
            ->addColumn('title', 'string', [
                'limit' => 30,
                'default' => null,
                'null' => true
            ])
            ->addColumn('directory', 'string', ['limit' => 2])
            ->addColumn('file', 'string', ['limit' => 150])
            ->addColumn('suffix', 'string', ['limit' => 5])
            ->addColumn('type', 'string', ['limit' => 10])
            ->addIndex(['uuid'], ['unique' => true])
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
