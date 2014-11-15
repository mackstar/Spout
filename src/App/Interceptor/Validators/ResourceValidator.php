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

class ResourceValidator implements MethodInterceptor
{
    const ID = 0;
    const TYPE = 1;
    const TITLE = 2;
    const SLUG = 3;

    use ResourceInject;

    /**
     * @var array
     */
    private $errors = [];

    /**
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

        if (!$validator->get('notempty')->isValid($args[self::TITLE])) {
            $this->errors['title'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::TYPE]['id'])) {
            $this->errors['type'] = $validator->getMessages()[0];
        }

        if (!$validator->get('notempty')->isValid($args[self::TYPE]['id'])) {
            $this->errors['type'] = $validator->getMessages()[0];
        }

        if (empty($this->errors) && !$this->isUniqueResourceName($args[self::TYPE]['slug'], $args[self::SLUG], $id)) {
            $this->errors['slug'] = 'The slug has already been taken for this media type.';
        }

        if (implode('', $this->errors)  == '') {
            return $invocation->proceed();
        }

        return $this->resource->get->uri('app://spout/exceptions/validation')
            ->withQuery(['errors' => $this->errors])
            ->eager
            ->request();
    }

    private function isUniqueResourceName($type, $slug, $id = null)
    {
        $result = $this->resource->get->uri('app://spout/resources/detail')
            ->withQuery(['type' => $type, 'slug' => $slug])
            ->eager
            ->request();

        return (
            $result->body['resource'] == false ||
                (!is_null($id) && $result->body['resource']['id'] == $id)

        );

    }
}
