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

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class SortByDateFilter implements HolidayFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        $flatList = $holidayList->getList();
        usort($flatList, function (Holiday $o1, Holiday $o2) {
            return $o1->getTimestamp() > $o2->getTimestamp();
        });
        $newList = new HolidayList();
        foreach ($flatList as $holiday) {
            $newList->add($holiday);
        }

        return $newList;
    }
}
