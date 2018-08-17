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

class HolidayCalculator implements HolidayCalculatorInterface
{
    /**
     * @var HolidayProviderInterface[]
     */
    private $holidayProviders = [];

    /**
     * @param HolidayProviderInterface[]|HolidayProviderInterface $holidayProviders
     *
     * @throws \InvalidArgumentException if $holidayProviders has an invalid type
     */
    public function __construct($holidayProviders = [])
    {
        if (false === \is_array($holidayProviders)) {
            if (false === $holidayProviders instanceof HolidayProviderInterface) {
                throw new \InvalidArgumentException('First argument needs to be either of type HolidayProviderInterface or an array consisting only of HolidayProviderInterface objects');
            }
            $holidayProviders = [ $holidayProviders ];
        }
        foreach ($holidayProviders as $holidayProvider) {
            $this->addHolidayProvider($holidayProvider);
        }
    }

    public function addHolidayProvider(HolidayProviderInterface $holidayProvider): void
    {
        $this->holidayProviders[$holidayProvider->getId()] = $holidayProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = new HolidayList();
        foreach ($this->holidayProviders as $holidayProvider) {
            $holidays->addAll($holidayProvider->calculateHolidaysForYear($year, $timezone));
        }

        return $holidays;
    }
}
