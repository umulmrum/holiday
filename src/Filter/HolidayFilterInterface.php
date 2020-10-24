<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\HolidayList;

interface HolidayFilterInterface
{
    /**
     * Applies a filter algorithm to the $holidayList, so that the result
     * is either reduced in size or sorted afterwards.
     * The filter MUST return a new HolidayList object and MAY NOT modify
     * the passed one.
     */
    public function filter(HolidayList $holidayList): HolidayList;
}
