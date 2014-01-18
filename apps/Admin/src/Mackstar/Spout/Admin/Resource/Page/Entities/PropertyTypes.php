<?php

namespace Mackstar\Spout\Admin\Resource\Page\Entities;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Entity/PropertyTypes page
 */
class PropertyTypes extends ResourceObject
{
    use ResourceInject;

    /**
     * @var array
     */
    public $body = [
        'greeting' =>  ''
    ];

    public function onGet($name = 'BEAR.Sunday')
    {
        $this['greeting'] = 'Hello ' . $name;
        return $this;
    }
}