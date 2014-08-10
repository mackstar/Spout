<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Interceptor\Users;

use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Symfony\Component\HttpFoundation\Session\Session as PhpSession;

/**
 * Access
 * 
 * @Db
 */
class Access implements MethodInterceptor
{

    use DbSetterTrait;
    use ResourceInject;

    private $session;

    /**
     * @Inject
     * @param PhpSession $session
     */
    public function setSession(PhpSession $session)
    {
        $this->session = $session;
    }


    public function invoke(MethodInvocation $invocation)
    {
        
        $object = $invocation->getThis();
        $user = $this->session->get('user');

        if ($this->isAccessDenied($object->uri, $user)) {
            return $this->resource->get
                ->uri('app://spout/exceptions/accessdenied')
                ->eager
                ->request();
        }

        return $invocation->proceed();
    }

    private function isAccessDenied($uri, $user)
    {

        if (strpos($uri, 'app://spout') === false) {
            return false;
        }

        if (strpos($uri, 'app://spout/exceptions') !== false) {
            return false;
        }

        if (strpos($uri, 'app://spout/users/authenticate') !== false) {
            return false;
        }

        if (!is_null($user)) {
            return false;
        }

        if ($this->isFirstUserRecordCreation($uri)) {
            return false;
        }

        return true;
    }

    private function isFirstUserRecordCreation($uri)
    {
        if (strpos($uri, 'app://spout/users/index') === false) {
            return false;
        }

        if ($this->db->executeQuery("SELECT id FROM users")->rowCount() == 0) {
            return true;
        }

        return false;
    }
}
