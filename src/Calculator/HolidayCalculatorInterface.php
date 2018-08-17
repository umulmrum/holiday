<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\Exception\HolidayException;
use umulmrum\Holiday\Model\HolidayList;

/**
 * @codeCoverageIgnore
 */
interface HolidayCalculatorInterface
{
    /**
     * Calculates all holidays for a given $year.
     *
     * @param int           $year
     * @param \DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList;
}
