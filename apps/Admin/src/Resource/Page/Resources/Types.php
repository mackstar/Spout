<?php

namespace Mackstar\Spout\Admin\Resource\Page\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Resource/FieldTypes page
 */
class Types extends ResourceObject
{
    use ResourceInject;

    /**
     * @var array
     */
    public $body = [
        'resource_types' =>  ''
    ];

    public function onGet()
    {
        $this['resource_types'] = $this->resource
            ->get
            ->uri('app://self/resources/types')
            ->eager
            ->request()['types'];

        return $this;
    }
}
