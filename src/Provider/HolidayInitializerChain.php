<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider;

use umulmrum\Holiday\Calculator\HolidayCalculator;

class HolidayInitializerChain implements HolidayInitializerInterface
{
    /**
     * @var HolidayInitializerInterface[]
     */
    private $holidayInitializers = [];

    /**
     * @param HolidayInitializerInterface[] $holidayInitializers
     */
    public function __construct(array $holidayInitializers)
    {
        foreach ($holidayInitializers as $holidayInitializer) {
            $this->addHolidayInitializer($holidayInitializer);
        }
    }

    /**
     * @param HolidayInitializerInterface $holidayInitializer
     */
    private function addHolidayInitializer(HolidayInitializerInterface $holidayInitializer)
    {
        $this->holidayInitializers[] = $holidayInitializer;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeHolidays(HolidayCalculator $holidayCalculator)
    {
        foreach ($this->holidayInitializers as $holidayInitializer) {
            $holidayInitializer->initializeHolidays($holidayCalculator);
        }
    }
}
