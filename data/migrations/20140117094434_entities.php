<?php

use Phinx\Migration\AbstractMigration;

class Entities extends AbstractMigration
{   
    /**
     * Migrate Up.
     */
    public function up()
    {
        $entities = $this->table('entities');
        $entities
            ->addColumn('type', 'string', array('limit' => 25))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entities');
    }
}