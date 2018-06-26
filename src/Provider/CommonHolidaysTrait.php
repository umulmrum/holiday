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

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;

trait CommonHolidaysTrait
{
    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getNewYear($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::NEW_YEAR, new DateTime(sprintf('%s-01-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getLaborDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::LABOR_DAY, new DateTime(sprintf('%s-05-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}
