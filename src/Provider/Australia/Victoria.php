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
use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Victoria extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getLaborDayVictoria($year, HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSaturday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 2016) {
            $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidays->add($this->getFridayAustralianFootball($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year <= 1994) {
            $holidays->add($this->getEasterTuesday($year, HolidayType::OFFICIAL | HolidayType::BANK));
        }
        $holidays->add($this->getMelbourneCup($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));

        return $holidays;
    }

    protected function getLaborDayVictoria(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::LABOR_DAY,
            new DateTimeImmutable("Second Monday of {$year}-03"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getFridayAustralianFootball(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        if ($year === 2020) {
            return Holiday::create(HolidayName::FRIDAY_AUSTRALIAN_FOOTBALL, '2020-10-23', HolidayType::OFFICIAL | $additionalType);
        }

        return Holiday::createFromDateTime(
            HolidayName::FRIDAY_AUSTRALIAN_FOOTBALL,
            new DateTimeImmutable("Last Friday of {$year}-09"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getMelbourneCup(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::MELBOURNE_CUP,
            new DateTimeImmutable("First Tuesday of {$year}-11"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        if ($year >= 2008) {
            return parent::getCompensatoryDaysCalculators($year);
        }

        return [new CompensatoryDaysCalculator(
            [
                HolidayName::NEW_YEAR,
                HolidayName::BOXING_DAY,
            ],
            [],
            [Weekday::SUNDAY],
        )];
    }
}
