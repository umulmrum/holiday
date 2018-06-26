<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

interface HolidayFormatterInterface
{
    /**
     * Formats a single Holiday object. Implementations may be configured using the $options array (depending completely
     * on the concrete implementation).
     *
     * @param Holiday $holiday
     * @param array   $options
     *
     * @return int|string
     */
    public function format(Holiday $holiday, array $options = []);

    /**
     * Formats a list of Holiday objects. Implementations may be configured using the $options array (depending completely
     * on the concrete implementation).
     *
     * @param HolidayList $holidayList
     * @param array       $options
     *
     * @return int[]|string[]
     */
    public function formatList(HolidayList $holidayList, array $options = []);
}
