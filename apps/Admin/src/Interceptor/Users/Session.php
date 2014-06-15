<?php

namespace Mackstar\Spout\Admin\Interceptor\Users;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Symfony\Component\HttpFoundation\Session\Session as PhpSession;

class Session implements MethodInterceptor
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
        $response = $invocation->proceed();
        $response->body['_user'] = $this->session->get('user');
        return $response;
    }
}
