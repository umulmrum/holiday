<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Australia;

use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Tasmania extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getRoyalHobartRegatta($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getEightHoursDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getEasterTuesday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        if ($year >= 1919 && $year !== 1990) {
            $holidays->add($this->getRecreationDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }

        return $holidays;
    }

    protected function getRoyalHobartRegatta(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::ROYAL_HOBART_REGATTA,
            new DateTimeImmutable("Second Monday of {$year}-02"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getEightHoursDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::EIGHT_HOURS_DAY,
            new DateTimeImmutable("Second Monday of {$year}-03"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getRecreationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            $year >= 1991 ? HolidayName::RECREATION_DAY : HolidayName::FIRST_MONDAY_IN_NOVEMBER,
            new DateTimeImmutable("First Monday of {$year}-11"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }
}
