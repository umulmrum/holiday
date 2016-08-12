<?php

namespace umulmrum\Holiday\Provider;

use DateTimeZone;
use umulmrum\Holiday\Model\HolidayList;

interface HolidayProviderInterface
{
    /**
     * Returns the ID of this provider. This MUST be a unique identifer, and if the provider represents a country or
     * region, this should be the corresponding ISO 3166 code.
     *
     * Providers should also expose this ID as a constant named ID to reference it in a static way.
     *
     * @return string
     */
    public function getId();

    /**
     * Calculates holidays for the given year.
     *
     * @param int          $year
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null);
}
