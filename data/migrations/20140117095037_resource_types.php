<?php

use Phinx\Migration\AbstractMigration;

class ResourceTypes extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $entityTypes = $this->table('resource_types');
        $entityTypes
            ->addColumn('name', 'string', array('limit' => 35))
            ->addColumn('slug', 'string', array('limit' => 35))
            ->addColumn('title_label', 'string', array('limit' => 35))
            ->addColumn('categories', 'integer', array('limit' => 1))
            ->addColumn('tags', 'integer', array('limit' => 1))
            ->save();

        $this->execute("INSERT INTO `resource_types` (`name`, `slug`, `title_label`, `categories`, `tags`) " .
            "VALUES ('Blog', 'blog', 'Title', 1, 1)");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('resource_types');
    }
}
