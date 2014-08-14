<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Params;

use BEAR\Resource\ParamProviderInterface;
use BEAR\Resource\ParamInterface;
use DateTime;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class CurrentTime implements ParamProviderInterface
{
    private $timezone;

    /**
     *  @Inject
     *  @Named("timezone=timezone")
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ParamInterface $param)
    {
        $dateTime = new DateTime($this->timezone);
        $time = $dateTime->format("Y-m-d H:i:s");
        return $param->inject($time);
    }
}
