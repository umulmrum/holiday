<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Slovenia;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Provider\HolidayInitializerInterface;

class SloveniaHolidayInitializer implements HolidayInitializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator)
    {
        $holidayCalculator->addHolidayProvider(new Slovenia());
    }
}
