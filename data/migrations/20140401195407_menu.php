<?php

use Phinx\Migration\AbstractMigration;

class Menu extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('menus');
        $table
            ->addColumn('name', 'string', ['limit' => 35])
            ->addColumn('slug', 'string', ['limit' => 35])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('menus');
    }
}
