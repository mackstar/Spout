<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Ray\Di\Di\Inject;

/**
 * Authenticate Users
 */
class Authenticate extends ResourceObject{

    use ResourceInject;

    protected $security;

    /**
     *  @Inject
     */
    public function setSecurity(SecurityInterface $security) {
        $this->security = $security;
    }

    public function onPost(
        $email,
        $password
    ) {

        $resource = $this->resource->get->uri('app://self/users/index')
            ->eager
            ->withQuery(['email' => $email])
            ->request();

        if ($this->security->match($password, $resource->body['user']['password'])) {
            $this['user'] = $resource->body['user'];
        }

        return $this;
    }

}