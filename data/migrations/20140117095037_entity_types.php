<?php

use Phinx\Migration\AbstractMigration;

class EntityTypes extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $entityTypes = $this->table('entity_types');
        $entityTypes
            ->addColumn('name', 'string', array('limit' => 35))
            ->addColumn('slug', 'string', array('limit' => 35))
            ->addColumn('categories', 'int', array('limit' => 1))
            ->addColumn('tags', 'int', array('limit' => 1))
            ->save();

        $this->execute("INSERT INTO `entity_types` (`name`, `slug`, `categories`, `tags`) " .
            "VALUES ('Blog', 'blog', 1, 1)");
        $this->execute("INSERT INTO `entity_types` (`name`, `slug`, `categories`, `tags`) " .
            "VALUES ('Pag', 'page', 1, 1)");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('entities_types');
    }
}
