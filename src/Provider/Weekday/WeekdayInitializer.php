<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Provider\HolidayInitializerInterface;

class WeekdayInitializer implements HolidayInitializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator)
    {
        $holidayCalculator->addHolidayProvider(new Sundays());
        $holidayCalculator->addHolidayProvider(new Mondays());
        $holidayCalculator->addHolidayProvider(new Tuesdays());
        $holidayCalculator->addHolidayProvider(new Wednesdays());
        $holidayCalculator->addHolidayProvider(new Thursdays());
        $holidayCalculator->addHolidayProvider(new Fridays());
        $holidayCalculator->addHolidayProvider(new Saturdays());
    }
}
