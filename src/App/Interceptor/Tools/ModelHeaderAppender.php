<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Interceptor\Tools;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\StringInterface;
use Ray\Di\Di\Inject;


class ModelHeaderAppender implements MethodInterceptor
{

    private $string;

    /**
     * @Inject
     */
    public function setString(StringInterface $string)
    {
        $this->string = $string;
    }

    public function invoke(MethodInvocation $invocation)
    {
        $response = $invocation->proceed();
        $path = parse_url($response->uri)['path'];
        $names = explode('/', $path);
        $i = count($names);
        $name = $names[$i-1];
        if ($name === 'index' || $name === 'search') {
            $name = $names[$i-2];
        }
        if (isset($response->body[$name])) {
            $modelName = $name;
        } else {
            $singular = $this->string->singularize($name);
            if ($name != $singular && isset($response->body[$singular])) {
                $modelName = $singular;
            }
        }


        if (isset($modelName)) {
            $response->body['_model'] = $modelName;
        }

        return $response;
    }
}
