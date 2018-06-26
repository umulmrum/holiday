<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Germany;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Provider\HolidayInitializerInterface;

class GermanyHolidayInitializer implements HolidayInitializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator)
    {
        $holidayCalculator->addHolidayProvider(new Germany());
        $holidayCalculator->addHolidayProvider(new BadenWuerttemberg());
        $holidayCalculator->addHolidayProvider(new Bavaria());
        $holidayCalculator->addHolidayProvider(new Berlin());
        $holidayCalculator->addHolidayProvider(new Brandenburg());
        $holidayCalculator->addHolidayProvider(new Bremen());
        $holidayCalculator->addHolidayProvider(new Hamburg());
        $holidayCalculator->addHolidayProvider(new Hesse());
        $holidayCalculator->addHolidayProvider(new MecklenburgVorpommern());
        $holidayCalculator->addHolidayProvider(new LowerSaxony());
        $holidayCalculator->addHolidayProvider(new NorthRhineWestphalia());
        $holidayCalculator->addHolidayProvider(new RhinelandPalatinate());
        $holidayCalculator->addHolidayProvider(new Saarland());
        $holidayCalculator->addHolidayProvider(new Saxony());
        $holidayCalculator->addHolidayProvider(new SaxonyAnhalt());
        $holidayCalculator->addHolidayProvider(new SchleswigHolstein());
        $holidayCalculator->addHolidayProvider(new Thuringia());
    }
}
