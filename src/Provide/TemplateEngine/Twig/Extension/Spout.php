<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\TemplateEngine\Twig\Entension;

use BEAR\Sunday\Inject\ResourceInject;
use Twig_Extension;
/**
 * Twig
 *
 * @see http://twig.sensiolabs.org/
 */
class Spout extends Twig_Extension
{
    use ResourceInject;

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'spout';
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getFilters()
    {
        return 'spout';
    }
}
