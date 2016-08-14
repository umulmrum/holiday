<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use DateTimeZone;
use umulmrum\Holiday\Exception\HolidayException;
use umulmrum\Holiday\Model\HolidayList;

/**
 * @codeCoverageIgnore
 */
interface HolidayCalculatorInterface
{
    /**
     * Calculates all holidays for a given $year in the desired $location.
     *
     * @param int          $year
     * @param string       $region   The alias for the region. This is what the getId() method of the holiday provider for this region returns.
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     *
     * @throws HolidayException
     */
    public function calculateHolidaysForYear($year, $region, DateTimeZone $timezone = null);
}
