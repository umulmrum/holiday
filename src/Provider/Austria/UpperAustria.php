<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Austria;


use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class UpperAustria extends Austria
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);
        if ($year <= 2003) {
            $holidays->add($this->getLeopoldsDay($year, HolidayType::OFFICIAL, $timezone));
        } else {
            $holidays->add($this->getSaintFloriansDay($year, HolidayType::OFFICIAL, $timezone));
        }

        return $holidays;
    }

}