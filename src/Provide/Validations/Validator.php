<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\Validations;

use Mackstar\Spout\Interfaces\ValidatorInterface;
use Mackstar\Spout\Interfaces\ValidatorProviderInterface;
use Ray\Di\Di\Inject;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class Validator implements ValidatorInterface
{
    private $validators;

    private $currentValidator;

    /**
     * @Inject
     */
    public function __construct(ValidatorProviderInterface $provider)
    {
        $this->validators = $provider->get();
    }

    public function get($type, $options = null)
    {
        $this->currentValidator = $this->validators[$type];
        return $this->currentValidator;
    }

    public function getMessages()
    {
        $messages = [];
        foreach ($this->currentValidator->getMessages() as $key => $val) {
            $messages[] = $val;
        }
        return $messages;
    }
    }
