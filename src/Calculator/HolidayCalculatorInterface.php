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

use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

/**
 * @codeCoverageIgnore
 */
interface HolidayCalculatorInterface
{
    /**
     * Calculates all holidays for a given $year.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param int                                                                 $year
     * @param \DateTimeZone                                                       $timezone
     *
     * @return HolidayList
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function calculateHolidaysForYear($holidayProviders, int $year, \DateTimeZone $timezone = null): HolidayList;
}
