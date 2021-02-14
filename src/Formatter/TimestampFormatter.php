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

final class TimestampFormatter implements HolidayFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday): string
    {
        return (string) $holiday->getDate()->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList)
    {
        $result = [];
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->format($holiday);
        }

        return $result;
    }
}
