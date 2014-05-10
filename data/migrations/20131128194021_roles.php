<?php

use Phinx\Migration\AbstractMigration;

class roles extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $roles = $this->table('roles');
        $roles->addColumn('name', 'string', array('limit' => 30))
              ->addColumn('weight', 'integer', array('limit' => 2))
              ->save();


        $this->execute("INSERT INTO `roles` (`name`, `weight`) VALUES ('Admin', 5)");
        $this->execute("INSERT INTO `roles` (`name`, `weight`) VALUES ('Editor', 4)");
        $this->execute("INSERT INTO `roles` (`name`, `weight`) VALUES ('Contributor', 3)");
        $this->execute("INSERT INTO `roles` (`name`, `weight`) VALUES ('Authenticated', 2)");
        $this->execute("INSERT INTO `roles` (`name`, `weight`) VALUES ('Anonymous', 1)");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('roles');
    }
}
