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

use Phinx\Config\Config;
use Phinx\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class RollbackMigration extends AbstractCommand
{
  
    private $paths = [];

    private $output;

    /**
     * Configures the Spout console application.
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('rollback-migration')
            ->setDescription('Rollback migrations.')
            ->addOption(
                '--location', '-l', InputArgument::OPTIONAL, 'The location of migration files. (spout|local)'
            )
            ->addOption(
                '--environment', '-e', InputArgument::OPTIONAL, 'The target environment')
            ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to migrate to');
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->loadConfig($input, $output);
        $this->rollback($input, $output);

    }

    protected function rollback(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        
        $environment = $input->getOption('environment');
        $version = $input->getOption('target');
        
        if (null === $environment) {
            $environment = $this->getConfig()->getDefaultEnvironment();
            $output->writeln('<comment>warning</comment> no environment specified, defaulting to: ' . $environment);
        } else {
            $output->writeln('<info>using environment</info> ' . $environment);
        }
        
        $envOptions = $this->getConfig()->getEnvironment($environment);
        $output->writeln('<info>using adapter</info> ' . $envOptions['adapter']);
        $output->writeln('<info>using database</info> ' . $envOptions['name']);
        
        // rollback the specified environment
        $start = microtime(true);
        $this->getManager()->rollback($environment, $version);
        $end = microtime(true);
        
        $output->writeln('');
        $output->writeln('<comment>All Done. Took ' . sprintf('%.4fs', $end - $start) . '</comment>');
    }

    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $conf = 'var/bootstrap/migrations.conf.php';
        $input->setOption('configuration', $conf);
        $configFilePath = $this->locateConfigFile($input);

        $configArray = include($configFilePath);
        $location = $input->getOption('location')?: "local";

        if ($input->getOption('location') == 'spout') {
            $configArray['paths']['migrations'] = dirname(dirname(__DIR__)) . '/data/migrations';
        }
        $migrationTable = $configArray['environments']['default_migration_table'];
        $migrationTable = 'sp_migration_' . $location;
        $configArray['environments']['default_migration_table'] = $migrationTable;
        $config = new Config($configArray, $configFilePath);

        $this->setConfig($config);
    }
}
