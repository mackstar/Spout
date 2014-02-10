<?php

namespace Mackstar\Spout\Admin\Interceptor\Tools;

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