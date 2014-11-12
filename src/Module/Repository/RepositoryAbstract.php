<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Module\Repository;

use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;

abstract class RepositoryAbstract
{
    use DbSetterTrait;

    
    protected function getQb() {
        return $this->db->createQueryBuilder();
    }

}