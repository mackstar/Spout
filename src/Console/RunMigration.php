<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class CreateMigration extends Command
{
  
    private $paths = [];

    private $output;

    /**
     * Configures the Spout console application.
     */
    protected function configure()
    {
        $this
            ->setName('create-migration')
            ->setDescription('Create migration file.')
            ->addOption(
                '--location', '-l', InputArgument::OPTIONAL, 'The location of migration files. (spout|local)'
            )
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the migration?');

    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $command = $this->getApplication()->find('create');
        $name = $input->getArgument('name');

        switch ($input->getOption('location')) {
            case 'spout':
                $conf = dirname(dirname(__DIR__)) . '/tests/conf/migrations.conf.php';
                break;
            case 'local':
            default:
                $conf = 'var/bootstrap/migrations.conf.php';
                break;
        }

        $arguments = [
            'command' => 'create',
            'name' => $name,
            '-c'  => $conf
        ];

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);
        return $returnCode;

    }
}
