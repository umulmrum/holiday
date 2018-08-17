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

use umulmrum\Holiday\Model\HolidayList;

/**
 * Defines a service that provides holidays for a certain scope, e.g. for one country.
 *
 * Implementations must be immutable after initialization (apart from caches).
 *
 * @codeCoverageIgnore
 */
interface HolidayProviderInterface
{
    /**
     * Calculates holidays for the given year.
     *
     * @param int          $year
     * @param \DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList;
}
