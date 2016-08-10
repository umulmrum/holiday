<?php

namespace umulmrum\Holiday\Provider;

use DateTimeZone;
use umulmrum\Holiday\Model\HolidayList;

interface HolidayProviderInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null);
}
