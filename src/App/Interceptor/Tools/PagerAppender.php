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


class PagerAppender implements MethodInterceptor
{

    public function invoke(MethodInvocation $invocation)
    {
        $response = $invocation->proceed();
        if (isset($response->headers['pager'])) {
            unset($response->headers['pager']['html']);
            $response->body['_pager'] = $response->headers['pager'];
            unset($response->headers['pager']);
        }
        return $response;
    }
}
