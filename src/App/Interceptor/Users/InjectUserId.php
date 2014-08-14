<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Interceptor\Users;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Symfony\Component\HttpFoundation\Session\Session as PhpSession;


class InjectUserId implements MethodInterceptor
{

    private $session;

    /**
     * @Inject
     * @param PhpSession $session
     */
    public function setSession(PhpSession $session)
    {
        $this->session = $session;
    }

    public function invoke(MethodInvocation $invocation)
    {
        
        $user = $this->session->get('user');
        $object = $invocation->getThis();
        $object->setUserId($user['id']);
        return $invocation->proceed();

    }
}
