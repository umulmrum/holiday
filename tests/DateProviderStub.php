<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test;

use umulmrum\Holiday\Helper\DateProviderInterface;

final class DateProviderStub implements DateProviderInterface
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getCurrentDate(): \DateTime
    {
        return $this->dateTime;
    }
}
