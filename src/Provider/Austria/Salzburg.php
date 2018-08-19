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


use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class Salzburg extends Austria
{
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);
        $holidays->add($this->getSaintRupertsDay($year, HolidayType::OFFICIAL | HolidayType::NO_SCHOOL, $timezone));

        return $holidays;
    }

    private function getSaintRupertsDay(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::SAINT_RUPERTS_DAY, new \DateTime(sprintf('%s-09-24', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }
}