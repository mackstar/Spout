<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Interceptor\Validators;

use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\ValidatorInterface;
use Ray\Di\Di\Inject;

/**
 * UserValidator
 */
class UserValidator implements MethodInterceptor
{
    const EMAIL = 0;
    const NAME = 1;
    const ROLE = 2;
    const PASSWORD = 3;
    const ID = 3;

    use ResourceInject;

    /**
     * Errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * Error
     *
     * @var validator
     */
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
        $method = $invocation->getMethod()->name;

        $id = ($method == 'onPut')?  $args[self::ID] : null;

        if (!$validator->get('emailaddress')->isValid($args[self::EMAIL])) {
            $this->errors['email'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::NAME])) {
            $this->errors['name'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::ROLE]['id'])) {
            $this->errors['role'] = $validator->getMessages()[0];
        }

        if ($method == 'onPost' && !$validator->get('notempty')->isValid($args[self::PASSWORD])) {
            $this->errors['password'] = $validator->getMessages()[0];
        }

        if (!isset($this->errors['email']) && !$this->isUniqueEmail($args[self::EMAIL], $id)) {
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

    private function isUniqueEmail($email, $id)
    {
        $result = $this->resource->get->uri('app://self/users/index')
            ->withQuery(['email' => $email])
            ->eager
            ->request();

        return (
            $result->body['user'] == false ||
                ($id && $result->body['user']['id'] == $id)

        );

    }
}
