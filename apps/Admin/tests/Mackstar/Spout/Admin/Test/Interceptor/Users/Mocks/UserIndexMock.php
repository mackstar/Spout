<?php

namespace Mackstar\Spout\Admin\Test\Interceptor\Users\Mocks;

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

}