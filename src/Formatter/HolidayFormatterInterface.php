<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Formatter;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

interface HolidayFormatterInterface
{
    /**
     * Formats a single Holiday object. Implementations may be configured using the $options array (depending completely
     * on the concrete implementation).
     */
    public function format(Holiday $holiday, array $options = []): string;

    /**
     * Formats a list of Holiday objects. Implementations may be configured using the $options array (depending completely
     * on the concrete implementation).
     *
     * @return string|string[]
     */
    public function formatList(HolidayList $holidayList, array $options = []);
}
