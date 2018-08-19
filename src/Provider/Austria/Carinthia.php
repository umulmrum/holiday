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
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Carinthia extends Austria
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);
        $holidays->add($this->getSaintJosephsDay($year, HolidayType::OFFICIAL | HolidayType::NO_SCHOOL | HolidayType::GOVERNMENT_AGENCIES_CLOSED, $timezone));
        if ($year > 1920) {
            $holidays->add($this->getCarinthianPlebisciteDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        }

        return $holidays;
    }

    private function getCarinthianPlebisciteDay(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::CARINTHIAN_PLEBISCITE_DAY, new \DateTime(sprintf('%s-10-26', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}