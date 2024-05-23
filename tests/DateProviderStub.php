<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test;

use DateTime;
use Umulmrum\Holiday\Helper\DateProviderInterface;

final readonly class DateProviderStub implements DateProviderInterface
{
    public function __construct(private DateTime $dateTime) {}

    public function getCurrentDate(): DateTime
    {
        return $this->dateTime;
    }
}
