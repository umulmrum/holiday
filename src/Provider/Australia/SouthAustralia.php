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

class SouthAustralia extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year >= 1973) {
            $holidays->add($this->getAdelaideCupDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getEasterSaturday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDaySouthAustralia($year, HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));
        if ($year >= 1910) {
            $this->addProclamationDay($holidays, $year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        }
        $holidays->add($this->getNewYearsEve($year, HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));

        return $holidays;
    }

    protected function getAdelaideCupDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        if ($year <= 2005) {
            $date = new DateTimeImmutable("Third Monday of {$year}-05");
        } else {
            $date = new DateTimeImmutable("Second Monday of {$year}-03");
        }

        return Holiday::createFromDateTime(
            HolidayName::ADELAIDE_CUP_DAY,
            $date,
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getLaborDaySouthAustralia(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::LABOR_DAY,
            new DateTimeImmutable("First Monday of {$year}-10"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function addProclamationDay(HolidayList $holidays, int $year, int $additionalType = HolidayType::OTHER): void
    {
        if ($year <= 1992) {
            $holiday = Holiday::create(
                HolidayName::PROCLAMATION_DAY,
                "{$year}-12-28",
                HolidayType::OFFICIAL | $additionalType,
            );
            $holidays->add($holiday);
            $this->addLaterCompensatoryDay($holidays, $holiday);

            return;
        }

        $holidays->add(Holiday::create(
            HolidayName::PROCLAMATION_DAY,
            "{$year}-12-26",
            HolidayType::OFFICIAL | $additionalType,
        ));
    }
}
