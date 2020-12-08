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

abstract class AbstractSortFilter implements HolidayFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): void
    {
        $sorted = $holidayList->getList();
        \usort($sorted, $this->getCompareFunction());
        foreach ($sorted as $index => $holiday) {
            $holidayList->replaceByIndex($index, $holiday);
        }
    }

    /**
     * Returns a callable that takes two Holiday arguments and returns:
     * - 1 is argument 1 is greater
     * - -1 if argument 2 is greater
     * - 0 if the arguments are equal.
     */
    abstract protected function getCompareFunction(): callable;
}
