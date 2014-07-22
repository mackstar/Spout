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

class PreTest extends Command
{
  
    private $paths = [];

    private $output;

    /**
     * Configures the Spout console application.
     */
    protected function configure()
    {
        $this
            ->setName('pre-test')
            ->setDescription('Migrate database for tests.');
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $command = $this->getApplication()->find('migrate');

        $arguments = [
            'command' => 'migrate',
            '--environment'    => 'test',
            '-c'  => dirname(dirname(__DIR__)) . '/tests/conf/migration.conf.php'
        ];

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);
        return $returnCode;

    }
}
