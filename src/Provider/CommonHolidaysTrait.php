<?php

namespace umulmrum\Holiday\Provider;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;

trait CommonHolidaysTrait
{
    /**
     * @param int $year
     * @param int $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getNewYear($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::NEW_YEAR, new DateTime(sprintf('%s-01-01', $year)), HolidayType::OFFICIAL | $additionalType, $timezone);
    }

    /**
     * @param int $year
     * @param int $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getLaborDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::LABOR_DAY, new DateTime(sprintf('%s-05-01', $year)), HolidayType::OFFICIAL | $additionalType, $timezone);
    }
}
