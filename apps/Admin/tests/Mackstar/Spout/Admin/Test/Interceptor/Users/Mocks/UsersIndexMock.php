<?php

namespace Mackstar\Spout\Admin\Test\Interceptor\Users\Mocks;

class UsersIndexMock
{

    public $body = [];

    public function onGet()
    {
         $this->body['users'] = [[
             'name' => 'Richard',
             'password' => 'somehash'
         ]];
         return $this;
    }

}
