<?php

namespace Mackstar\Spout\Admin\Resource\Page\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Resource/FieldTypes page
 */
class FieldTypes extends ResourceObject
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
