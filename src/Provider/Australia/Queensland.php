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

class Queensland extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getEasterSaturday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDayQueensland($year, HolidayType::DAY_OFF));
        if ($year === 2012 || $year >= 2016) {
            $holidays->removeByName(HolidayName::KINGS_BIRTHDAY);
            $holidays->add($this->getKingsBirthdayQueensland($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getPeoplesDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));

        return $holidays;
    }

    protected function getLaborDayQueensland(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::MAY_DAY,
            new DateTimeImmutable("First Monday of {$year}-05"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getKingsBirthdayQueensland(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(HolidayName::KINGS_BIRTHDAY, new DateTimeImmutable("First Monday of {$year}-10"), HolidayType::OFFICIAL | $additionalType);
    }

    protected function getPeoplesDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::PEOPLES_DAY,
            new DateTimeImmutable("{$year}-08-10 this Wednesday"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }
}
