<?php

namespace Mackstar\Spout\Admin\Interceptor\Tools;

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
		var_dump(get_class_methods($response));
		exit;
		return $response;
	}
}