<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoryResourceType extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute(
            "INSERT INTO `resource_types` (`name`, `slug`, `title_label`, `categories`, `tags`) " .
            "VALUES ('Category', 'category', 'Category Name', 0, 1)"
        );
        $stub = "INSERT INTO `resource_fields` " .
            "(`resource_type`, `field_type`, `label`, `slug`, `multiple`, `weight`) VALUES ";

        $this->execute($stub . " ('category', 'text', 'Body', 'body',  0, 2)");
        $this->execute($stub . " ('category', 'string', 'Meta Keywords', 'meta-keywords', 1, 3)");
        $this->execute($stub . " ('category', 'string', 'Meta Description', 'meta-description', 0, 3)");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute("DELETE FROM `resource_types` WHERE `slug` = 'category'");
        $this->execute("DELETE FROM `resource_fields` WHERE `resource_type` = 'category'");
    }
}