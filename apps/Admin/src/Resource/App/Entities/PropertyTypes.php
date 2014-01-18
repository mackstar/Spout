<?php

namespace Mackstar\Spout\Admin\Resource\App\Entities;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * PropertyTypes
 *
 * @Db
 */
class PropertyTypes extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'property_types';

    public function onGet($id = null)
    {

        return $this;
    }
}