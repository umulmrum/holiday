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
use umulmrum\Holiday\Provider\HolidayInitializerInterface;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Exception\HolidayException;

class HolidayCalculator implements HolidayCalculatorInterface
{
    /**
     * @var HolidayProviderInterface[]
     */
    private $holidayProviders = [];
    /**
     * @var HolidayInitializerInterface
     */
    private $holidayInitializer;
    /**
     * @var bool
     */
    private $initialized = false;

    public function __construct(HolidayInitializerInterface $holidayInitializer = null)
    {
        if (null === $holidayInitializer) {
            $this->initialized = true;
        } else {
            $this->holidayInitializer = $holidayInitializer;
        }
    }

    public function addHolidayProvider(HolidayProviderInterface $holidayProvider): void
    {
        $this->holidayProviders[$holidayProvider->getId()] = $holidayProvider;
    }

    private function init(): void
    {
        if ($this->initialized) {
            return;
        }
        $this->holidayInitializer->initializeHolidays($this);
    }

    /**
     * {@inheritdoc}
     *
     * @throws HolidayException
     */
    public function calculateHolidaysForYear($year, $region, \DateTimeZone $timezone = null): HolidayList
    {
        $this->init();
        if (false === isset($this->holidayProviders[$region])) {
            throw new HolidayException('Invalid location alias: '.$region);
        }
        $holidays = $this->holidayProviders[$region]->calculateHolidaysForYear($year, $timezone);

        return $holidays;
    }
}
