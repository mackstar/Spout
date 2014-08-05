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
use Aura\Router\Router as ARouter;
use BEAR\Package\Provide\Router\Adapter\AdapterInterface;

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
    public function __construct(ARouter $router)
    {
        $this->router = $router;
        $this->setDefaultRoutes();
    }

    /**
     * Sets default routes for spout app
     */
    private function setDefaultRoutes()
    {
        $this->add('spout', [
            ['spout-admin', '/spoutadmin', 'spoutadmin'],
            ['api', '/api/{path}', null, ['tokens' => ['path' => '.+']]],
        ]);
    }

    /**
     * @return Router $router
     */
    public function get()
    {
        return $this->router;
    }

    /**
     * @return Router $router
     */
    public function add($app, $array)
    {
        foreach($array as $route) {
            $values = ['app' => $app];
            if (isset($route[2]) && !is_null($route[2])) {
                $values['path'] = $route[2];
            }
            $tokens = [];


            if (!empty($route[3])) {
                $values += isset($route[3]['values'])? $route[3]['values'] : [];
                $tokens += isset($route[3]['tokens'])? $route[3]['tokens'] : [];
            }
            $this->router->add($route[0], $route[1])->addValues($values)->addTokens($tokens);
        }
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
        unset($params['REQUEST_METHOD']);
        $request = ($globals['_SERVER']['REQUEST_METHOD'] === 'GET' || $globals['_SERVER']['REQUEST_METHOD'] === 'DELETE' ) ? $globals['_GET'] : $globals['_POST'];
        $query = $params + $request;

        if($globals['_FILES']) {
            $query += $globals['_FILES'];
        }
        
        $path = $params['path'];
        unset(
            $query[self::METHOD_FILED],
            $query['controller'],
            $query['path'], 
            $query['action'],
            $query['app']
        );
        return [strtolower($method), $path, $route->values['app'], $query];
    }
}
