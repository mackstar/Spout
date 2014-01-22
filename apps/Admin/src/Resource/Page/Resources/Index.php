<?php

namespace Mackstar\Spout\Admin\Resource\Page\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Resources/PropertyTypes page
 */
class Index extends ResourceObject
{
    use ResourceInject;

    /**
     * @var array
     */
    public $body = [
        'greeting' =>  ''
    ];

    public function onGet()
    {
        return $this;
    }
}