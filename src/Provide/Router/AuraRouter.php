<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Router;

use Aura\Web\Request\Method;
use Aura\Router\Router;

/**
 * Aura.Router (v2)
 *
 * @see https://github.com/auraphp/Aura.Router
 */
final class AuraRouter implements AdapterInterface
{
    const METHOD_FILED = '_method';

    const METHOD_OVERRIDE_HEADER = 'HTTP_X_HTTP_METHOD_OVERRIDE';

    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }



    /**
     * @param string $path
     * @param array  $globals
     *
     * @return array [$method, $path, $query]
     */
    public function match($path, array $globals = [])
    {
        $route = $this->router->match($path, $globals['_SERVER']);
        if ($route === false) {
            return false;
        }
        $method = (new Method($globals['_SERVER'], $globals['_POST'], self::METHOD_FILED))->get();
        $params = $route->params;
        unset($params['path']);
        unset($params['REQUEST_METHOD']);
        $request = ($globals['_SERVER']['REQUEST_METHOD'] === 'GET') ? $globals['_GET'] : $globals['_POST'];
        $query = $params + $request;
        unset($query[self::METHOD_FILED]);
        return [strtolower($method), $route->values['path'], $query];
    }
}
