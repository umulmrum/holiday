<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use Umulmrum\Holiday\Model\HolidayList;

interface HolidayFilterInterface
{
    /**
     * Applies a filter algorithm to the $holidayList which means that holidays in the list can be modified in any way
     * (removed, replaced, sorted, added).
     */
    public function filter(HolidayList $holidayList): void;
}
