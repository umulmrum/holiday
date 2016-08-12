<?php

namespace umulmrum\Holiday\Provider;

use umulmrum\Holiday\Calculator\HolidayCalculator;

interface HolidayInitializerInterface
{
    /**
     * Initializes the given HolidayCalculator with some holiday providers.
     * 
     * @param HolidayCalculator $holidayCalculator
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator);
}
