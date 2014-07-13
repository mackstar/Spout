<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\TemplateEngine\Twig;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class TwigModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('BEAR\Sunday\Extension\TemplateEngine\TemplateEngineAdapterInterface')
            ->to('BEAR\Package\Provide\TemplateEngine\Twig\TwigAdapter')
            ->in(Scope::SINGLETON);
        $this
            ->bind('Twig_Environment')
            ->toProvider(__NAMESPACE__ . '\TwigProvider')
            ->in(Scope::SINGLETON);
    }
}
