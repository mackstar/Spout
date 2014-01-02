<?php

namespace Mackstar\Spout\Admin\Interceptor\Validators;

use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\ValidatorInterface;
use Ray\Di\Di\Inject;


/**
 * UserValidator
 *
 * @Db
 */
class UserValidator implements MethodInterceptor
{
    const EMAIL = 0;
    const NAME = 1;
    const PASSWORD = 2;
    const ROLE = 3;

    use ResourceInject;

    use DbSetterTrait;
    
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

        if (!$validator->get('emailaddress')->isValid($args[self::EMAIL])) {
            $this->errors['email'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::NAME])) {
            $this->errors['name'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::ROLE]['id'])) {
            $this->errors['role'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::PASSWORD])) {
            $this->errors['password'] = $validator->getMessages()[0];
        }
        
        if (implode('', $this->errors)  == '') {
            return $invocation->proceed();
        }

        return $this->resource->get->uri('app://self/exceptions/validation')
            ->withQuery(['errors' => $this->errors])
            ->eager
            ->request();
    }
}