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

use BEAR\Sunday\Inject\LibDirInject;
use BEAR\Sunday\Inject\TmpDirInject;
use BEAR\Sunday\Inject\ResourceInject;
use Ray\Di\ProviderInterface as Provide;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Twig
 *
 * @see http://twig.sensiolabs.org/
 */
class TwigProvider implements Provide
{
    use TmpDirInject;
    use LibDirInject;
    use ResourceInject;

    /**
     * Return instance
     *
     * @return \Twig_Environment
     */
    public function get()
    {
        $loader = new Twig_Loader_Filesystem(array('/', $this->libDir . '/twig/template'));
        $twig = new Twig_Environment($loader, [
            'cache' => $this->tmpDir . '/twig/cache',
            'debug' => true,
            'autoescape' => false,
        ]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $function = new \Twig_SimpleFunction(
            'resource',
            [$this, 'resource']
        );
        $twig->addFunction($function);
        return $twig;
    }

    public function resource($resource, $template)
    {
        $template = str_replace('.', '/', $template);
        $result = $this->resource->get->uri($resource)
            ->eager
            ->withTemplate($template)
            ->request();
        return $result;
    }
}
