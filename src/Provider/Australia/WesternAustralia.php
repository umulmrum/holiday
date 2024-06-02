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
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

use function in_array;

class WesternAustralia extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getLaborDayWesternAustralia($year, HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWesternAustraliaDay($year, HolidayType::DAY_OFF));
        $holidays->removeByName(HolidayName::KINGS_BIRTHDAY);
        $holidays->add($this->getKingsBirthdayWesternAustralia($year, HolidayType::DAY_OFF));
        $this->addCompensatoryHolidayForAnzacDay($holidays);

        return $holidays;
    }

    protected function getLaborDayWesternAustralia(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::LABOR_DAY,
            new DateTimeImmutable("First Monday of {$year}-03"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getWesternAustraliaDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            $year >= 2012 ? HolidayName::WESTERN_AUSTRALIA_DAY : HolidayName::FOUNDATION_DAY,
            new DateTimeImmutable("First Monday of {$year}-06"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getKingsBirthdayWesternAustralia(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        if ($year === 2011) {
            return Holiday::create(HolidayName::KINGS_BIRTHDAY, '2011-10-28', HolidayType::OFFICIAL | $additionalType);
        }

        if (in_array(
            $year,
            [
                1956,
                1961,
                1962,
                1967,
                1972,
                1973,
                1978,
                1979,
                1984,
                1989,
                1990,
                1995,
                2000,
                2001,
                2004,
                2006,
                2007,
                2012,
            ],
            true,
        )) {
            return Holiday::createFromDateTime(
                HolidayName::KINGS_BIRTHDAY,
                new DateTimeImmutable("First Monday of {$year}-10"),
                HolidayType::OFFICIAL | $additionalType,
            );
        }

        return Holiday::createFromDateTime(
            HolidayName::KINGS_BIRTHDAY,
            new DateTimeImmutable("Last Monday of {$year}-09"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function addCompensatoryHolidayForAnzacDay(HolidayList $holidays): void
    {
        $anzacDayList = $holidays->getByName(HolidayName::ANZAC_DAY);
        if ($anzacDayList === []) {
            return;
        }
        $this->addLaterCompensatoryDay($holidays, $anzacDayList[0]);
    }
}
