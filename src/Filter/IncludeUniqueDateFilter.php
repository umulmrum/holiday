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

final class IncludeUniqueDateFilter implements HolidayFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        $foundTimestamps = [];

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            if (false === isset($foundTimestamps[$holiday->getTimestamp()])) {
                $newList->add($holiday);
                $foundTimestamps[$holiday->getTimestamp()] = true;
            }
        }

        return $newList;
    }
}
