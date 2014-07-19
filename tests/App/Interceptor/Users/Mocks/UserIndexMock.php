<?php

namespace Mackstar\Spout\Test\App\Interceptor\Users\Mocks;

class UserIndexMock
{

    public $body = [];

    public function onGet()
    {
         $this->body['user'] = [
             'name' => 'Richard',
             'password' => 'somehash'
         ];
         return $this;
    }

    public function onGetMultiple()
    {
         $this->body['users'] = [
            [
                'name' => 'Richard',
                'password' => 'somehash'
            ]
        ];
        return $this;
    }

}
