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
        (array) $args = $invocation->getArguments();
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

        if (is_array($args[self::PASSWORD]) && !$validator->get('notempty')->isValid($args[self::PASSWORD])) {
            $this->errors['password'] = $validator->getMessages()[0];
        }

        if (!isset($this->errors['email']) && !$this->isUniqueEmail($args[self::EMAIL])) {
            $this->errors['email'] = 'Email address already exists.';
        }
        
        if (implode('', $this->errors)  == '') {
            return $invocation->proceed();
        }

        return $this->resource->get->uri('app://self/exceptions/validation')
            ->withQuery(['errors' => $this->errors])
            ->eager
            ->request();
    }

    private function isUniqueEmail($email) {
        $result = $this->resource->get->uri('app://self/users/index')
            ->withQuery(['email' => $email])
            ->eager
            ->request();

        return ($result->body['user'] == false);

    }
}