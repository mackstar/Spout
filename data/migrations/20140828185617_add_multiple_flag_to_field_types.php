<?php

use Phinx\Migration\AbstractMigration;

class AddMultipleFlagToFieldTypes extends AbstractMigration
{    
    /**
     * Migrate Up.
     */
    public function up()
    {
        
        $roles = $this->table('field_types');
        $roles->addColumn('multiple', 'integer', ['limit' => 1, 'default' => 0])
              ->save();

        $this->execute(
            "UPDATE `field_types` SET multiple = 1 WHERE " .
            "slug = 'string' OR slug = 'text' OR slug = 'media'"
        );
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('field_types');
        $table->removeColumn('multiple')
            ->save();
    }
}