<?php

namespace Mackstar\Spout\Admin\Interceptor\Validators;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\ValidatorInterface;
use Ray\Di\Di\Inject;

class UserValidator implements MethodInterceptor
{
	// const TITLE = 0;
	// const BODY = 1;
	
	/**
	 * Error
	 * 
	 * @var array
	 */
	private $errors = [
		'email' => '',
		'name' => '',
        'role' => '',
        'password' => ''
	];

    private $validator; 

    /**
     * @Inject
     */
    public function setValidator(ValidatorInterface $validator)
    {
        var_dump("setValidator");
        exit;
        $this->validator = $validator;
    }
	
    public function invoke(MethodInvocation $invocation)
    {
    	$args = $invocation->getArguments();
    	$page = $invocation->getThis();
    	var_dump("UserValidator");
        var_dump($this->validator);
        exit;
    	// // strip tags
    	// foreach ($args as &$arg) {
    	// 	$arg = strip_tags($arg);
    	// }
    	
    	// // required title
    	// if ($args[self::TITLE] # = '') {
    	// 	$this->errors['title'] = 'title required.';
    	// }
    	
    	// // required body
    	// if ($args[self::BODY] # = '') {
    	// 	$this->errors['body'] = 'body required.';
    	// }
    	
    	// // valid form ?
    	// if (implode('', $this->errors) # = '') {
	    // 	return $invocation->proceed();
    	// }
    	
     //    // error, modify 'GET' page with error message.
    	// $page['errors'] = $this->errors;
    	// $page['submit'] =[
    	// 	'title' => $args[self::TITLE],
    	// 	'body' => $args[self::BODY]
    	// ];
    	// return $page->onGet();
    }
}