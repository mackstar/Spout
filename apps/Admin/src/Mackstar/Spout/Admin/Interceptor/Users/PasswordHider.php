<?php

namespace Mackstar\Spout\Admin\Interceptor\Users;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;


class PasswordHider implements MethodInterceptor
{

	public function invoke(MethodInvocation $invocation)
	{
		$response = $invocation->proceed();
		if (isset($response->body['user']['password'])) {
			unset($response->body['user']['password']);
		}
		return $response;
	}
}