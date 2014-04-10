<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Module;

use Ray\Di\AbstractModule;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class SecurityModule extends AbstractModule
{
	public function configure() {
		$this
            ->bind('Mackstar\Spout\Interfaces\SecurityInterface')
            ->to('Mackstar\Spout\Tools\Security');
	}
}
