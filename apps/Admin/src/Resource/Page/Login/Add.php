<?php

namespace Mackstar\Spout\Admin\Resource\Page\Login;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Login/add page
 */
class Add extends ResourceObject
{
    /**
     * @var array
     */
    public $body = ['title' => 'Login'];

    public function onGet()
    {
    }
}
