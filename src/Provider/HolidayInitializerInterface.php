<?php

namespace umulmrum\Holiday\Provider;

use umulmrum\Holiday\Calculator\HolidayCalculator;

interface HolidayInitializerInterface
{
    /**
     * @param HolidayCalculator $holidayCalculator
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator);
}
