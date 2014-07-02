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

use BEAR\Resource\Exception\BadRequest;
use BEAR\Resource\Exception\MethodNotAllowed;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Package\Provide\Router\Adapter\AdapterInterface;
use Ray\Di\Di\Inject;

final class Router implements RouterInterface
{
    const METHOD_FILED = '_method';

    const METHOD_OVERRIDE_HEADER = 'HTTP_X_HTTP_METHOD_OVERRIDE';

    /**
     * $GLOBALS
     *
     * @var array
     */
    private $globals;

    /**
     * @var AdapterInterface
     */
    protected $router;

    /**
     * @param AdapterInterface $router
     *
     * @Inject
     */
    public function __construct(AdapterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function setGlobals($global)
    {
        $this->globals = $global;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws BadRequest
     * @throws MethodNotAllowed
     */
    public function setArgv($argv)
    {
        if (count($argv) < 3) {
            throw new BadRequest('Usage: [get|post|put|delete] [uri]');
        }
        $globals['_SERVER']['REQUEST_METHOD'] = strtoupper($argv[1]);
        $globals['_SERVER']['REQUEST_URI'] = parse_url($argv[2], PHP_URL_PATH);
        parse_str(parse_url($argv[2], PHP_URL_QUERY), $query);
        $method = $argv[1] === 'get' ? '_GET' : '_POST';
        $globals[$method] = $query;
        $this->globals = $globals;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return AdapterInterface $router
     */
    public function get()
    {
        return $this->router;
    }

    /**
     * {@inheritDoc}
     *
     * @return array [$method, $pageUri, $query]
     */
    public function match()
    {

        $globals = $this->globals ? : $GLOBALS;
        $path = parse_url($globals['_SERVER']['REQUEST_URI'], PHP_URL_PATH);
        return $this->router->match($path, $globals);
    }
}