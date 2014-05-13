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
            ->addColumn('name', 'string', ['limit' => 35])
            ->addColumn('slug', 'string', ['limit' => 35])
            ->addColumn('title_label', 'string', ['limit' => 35])
            ->addColumn('categories', 'integer', ['limit' => 1, 'default' => 0])
            ->addColumn('tags', 'integer', ['limit' => 1, 'default' => 0])
            ->save();

        $this->execute(
            "INSERT INTO `resource_types` (`name`, `slug`, `title_label`, `categories`, `tags`) " .
            "VALUES ('Blog', 'blog', 'Title', 1, 1)"
        );
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('resource_types');
    }
}
