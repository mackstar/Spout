<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Validations;

use Mackstar\Spout\Interfaces\ValidatorProviderInterface;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class ValidatorProvider implements ValidatorProviderInterface
{
    private $validatorClasses = [
        'Between',
        'Date',
        'EmailAddress',
        'LessThan',
        'NotEmpty',
        'StringLength',
        'Uri',
        'Ip'
    ];

    public function get()
    {
        $validators = [];
        $validatorNamespace = 'Zend\\Validator\\';
        foreach ($this->validatorClasses as $className) {
            $fullClassName = $validatorNamespace . $className;
            $validators[strtolower($className)] = new $fullClassName();
        }
        return $validators;
    }
}
