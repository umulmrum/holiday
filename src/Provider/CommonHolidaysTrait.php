<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;

trait CommonHolidaysTrait
{
    private function getNewYear(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::NEW_YEAR, "{$year}-01-01", HolidayType::OFFICIAL | $additionalType);
    }

    private function getInternationalWomensDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INTERNATIONAL_WOMENS_DAY, "{$year}-03-08", HolidayType::OFFICIAL | $additionalType);
    }

    private function getLaborDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::LABOR_DAY, "{$year}-05-01", HolidayType::OFFICIAL | $additionalType);
    }

    private function getVictoryInEuropeDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::VICTORY_IN_EUROPE_DAY, "{$year}-05-08", HolidayType::OTHER | $additionalType);
    }

    private function getNewYearsEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::NEW_YEARS_EVE, "{$year}-12-31", HolidayType::OFFICIAL | $additionalType);
    }
}
