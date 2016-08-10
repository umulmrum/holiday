<?php

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Provider\HolidayInitializerInterface;

class WeekdayInitializer implements HolidayInitializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator)
    {
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::SUNDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::MONDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::TUESDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::WEDNESDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::THURSDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::FRIDAY));
        $holidayCalculator->addHolidayProvider(new Weekdays(Weekday::SATURDAY));
    }
}
