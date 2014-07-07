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

class Install extends Command
{
  
    private $paths = [];

    private $output;

    /**
     * Configures the Spout console application.
     */
    protected function configure()
    {
        $this
            ->setName('install')
            ->setDescription('Install and set up Spout application.')
            ->addOption('--environment', '-e', InputArgument::OPTIONAL, 'The target environment');
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        // Setup
        $this->setPaths();
        $this->output = $output;
        extract($this->paths);

        // Create directories
        $this->createDirectory($current . '/var/www/uploads/');
        $this->createDirectory($current . '/var/www/uploads/media/');
        $this->createDirectory($current . '/var/log/');
        $this->createDirectory($current . '/var/tmp/');
        $this->createDirectory($current . '/var/tmp/twig/');

        // Copy files
        $this->copyFiles($adminSrc, $adminDest);
        $this->copyFiles($migrationSrc, $migrationDest);
        $this->copyFiles($layoutSrc, $layoutDest);

        $command = $this->getApplication()->find('migrate');

        $arguments = [
            'command' => 'migrate',
            '--environment'    => $input->getOption('environment'),
            '-c'  => 'var/bootstrap/migrations.conf.php'
        ];

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);
        return $returnCode;

    }

    private function setPaths() {
        $current        =   getcwd();
        $spout          =   $current . '/vendor/mackstar/spout';

        // Admin assets
        $adminSrc       =   $spout . '/dist/spout-admin';
        $adminDest      =   $current . '/var/www/';

        // Migrations
        $migrationSrc   =   $spout . '/data/migrations/';
        $migrationDest  =   $current . '/lib/migrations/';

        // Layout files
        $layoutSrc      =   $spout . '/dist/template/layout/*';
        $layoutDest     =   $current . '/lib/twig/templates/';

        $this->paths = compact(
            'current',
            'adminSrc',
            'adminDest',
            'migrationSrc',
            'migrationDest',
            'layoutSrc',
            'layoutDest'
        );
    }


    private function createDirectory($dir) {
        if (is_dir($dir)) {
            return;
        }
        try {
            mkdir($dir);
            $this->output->writeln("<info>Created $dir</info>");
        } catch (\Exception $e) {
            $this->output->writeln("<error>Unable to write $dir</error>");
        }
        if (!is_dir($dir)) {
            $this->output->writeln("<error>$dir does not exist. Please create directory and run command again.</error>");
        }
    }

    public function copyFiles($files, $dest) {
        $this->createDirectory($dest);
        $this->output->writeln(
            str_replace($this->paths['current'] .'/', '', "<info>performing cp -R $files $dest</info>")
        );
        exec("cp -R $files $dest", $output);
        foreach($output as $line) {
            $this->output->writeln($line);
        }
    }
}
