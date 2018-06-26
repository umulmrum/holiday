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

use umulmrum\Holiday\Calculator\HolidayCalculator;

/**
 * @codeCoverageIgnore
 */
interface HolidayInitializerInterface
{
    /**
     * Initializes the given HolidayCalculator with some holiday providers.
     * 
     * @param HolidayCalculator $holidayCalculator
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator);
}
