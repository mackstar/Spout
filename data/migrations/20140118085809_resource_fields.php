<?php

use Phinx\Migration\AbstractMigration;

class ResourceFields extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('resource_fields');
        $table
            ->addColumn('resource_type', 'string', ['limit' => 35])
            ->addColumn('field_type', 'string', ['limit' => 35])
            ->addColumn('label', 'string', ['limit' => 35])
            ->addColumn('slug', 'string', ['limit' => 35])
            ->addColumn('multiple', 'integer', ['limit' => 1])
            ->addColumn('weight', 'integer', ['limit' => 10])
            ->save();

        $stub = "INSERT INTO `resource_fields` " .
            "(`resource_type`, `field_type`, `label`, `slug`, `multiple`, `weight`) VALUES ";

        $this->execute($stub . " ('blog', 'text', 'Body', 'body',  0, 2)");
        $this->execute($stub . " ('blog', 'string', 'Meta Keywords', 'meta-keywords', 1, 3)");
        $this->execute($stub . " ('blog', 'string', 'Meta Description', 'meta-description', 0, 3)");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('resource_fields');
    }
}
