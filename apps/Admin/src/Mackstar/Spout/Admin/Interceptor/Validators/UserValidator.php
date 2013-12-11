<?php

namespace Mackstar\Spout\Admin\Interceptor\Validators;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\ValidatorInterface;
use Ray\Di\Di\Inject;
use BEAR\Sunday\Inject\ResourceInject;


class UserValidator implements MethodInterceptor
{
	const EMAIL = 0;
	const NAME = 1;
    const ROLE = 2;
    const PASSWORD = 3;

    use ResourceInject;
	
	/**
	 * Error
	 * 
	 * @var array
	 */
	private $errors = [];

    private $validator; 

    /**
     * @Inject
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
	
    public function invoke(MethodInvocation $invocation)
    {
    	$args = $invocation->getArguments();
        $validator = $this->validator;

        if (!$validator->get('emailaddress')->isValid($args[self::EMAIL])) {
            $this->errors['email'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::NAME])) {
            $this->errors['name'] = $validator->getMessages()[0];
        }
    	
        // if (!$validator->get('notempty')->isValid($args[self::EMAIL])) {
        //     $this->errors['email'] = $validator->getMessages()[0];
        // }
    	
    	if (implode('', $this->errors)  == '') {
	    	return $invocation->proceed();
    	}

        return $this->resource->get->uri('app://self/exceptions/validation')
            ->withQuery(['errors' => $this->errors])
            ->eager
            ->request();
    }
}