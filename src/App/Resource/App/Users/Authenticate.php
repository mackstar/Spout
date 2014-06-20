<?php

namespace Mackstar\Spout\App\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation\Db;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Ray\Di\Di\Inject;

/**
 * Authenticate Users
 *
 * @Db
 */
class Authenticate extends ResourceObject
{

    use DbSetterTrait;

    protected $security;
    protected $session;
    protected $table = 'users';

    /**
     * @Inject
     */
    public function setSecurity(SecurityInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @Inject
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function onPost(
        $email,
        $password
    ) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && $this->security->match($password, $user['password'])) {
            unset($user['password']);
            $this->session->set('user', $user);
            $this['user'] = $user;
            $this['_model'] = 'user';
            return $this;
        }

        $this->code = 400;
        $this['title'] = 'Unable to login.';
        $this['message'] = 'Your authentication details didn\'t match.';
        return $this;
    }

    public function onDelete()
    {
        $this->session->remove('user');
        $this['title'] = 'Session successfully removed';
        return $this;
    }
}
