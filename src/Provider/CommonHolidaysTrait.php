<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider;

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;

trait CommonHolidaysTrait
{
    private function getNewYear(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::NEW_YEAR, new \DateTime(sprintf('%s-01-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    private function getLaborDay(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::LABOR_DAY, new \DateTime(sprintf('%s-05-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    private function getNewYearsEve(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::NEW_YEARS_EVE, new \DateTime(sprintf('%s-12-31', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}
