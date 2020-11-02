<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Weekday;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;

class Fridays extends Weekdays
{
    public function __construct(int $additionalType = HolidayType::OTHER)
    {
        parent::__construct(Weekday::FRIDAY, $additionalType);
    }
}
