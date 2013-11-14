<?php

namespace Mackstar\Spout\Admin\Interceptor\Users;

use BEAR\Sunday\Inject\NamedArgsInject;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;


class PasswordEncryptor implements MethodInterceptor
{
	use NamedArgsInject;

	public function invoke(MethodInvocation $invocation)
	{
		return $invocation->proceed();
	}
}