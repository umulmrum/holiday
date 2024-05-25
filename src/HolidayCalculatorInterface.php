<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday;

use InvalidArgumentException;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

interface HolidayCalculatorInterface
{
    /**
     * Calculates all holidays for a given $year.
     *
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $holidayProviders
     * @param int|int[]                                                           $years
     *
     * @return HolidayList order is not guaranteed; use filters to sort the list afterwards
     *
     * @throws InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function calculate($holidayProviders, $years): HolidayList;
}
