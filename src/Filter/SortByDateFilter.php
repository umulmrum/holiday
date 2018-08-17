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

class SortByDateFilter implements HolidayFilterInterface
{
    /**
     * @var HolidayFilterInterface
     */
    private $chainedFilter;

    public function __construct(HolidayFilterInterface $chainedFilter = null)
    {
        $this->chainedFilter = $chainedFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList, array $options = []): HolidayList
    {
        if (null !== $this->chainedFilter) {
            $holidayList = $this->chainedFilter->filter($holidayList, $options);
        }
        $flatList = $holidayList->getList();
        usort($flatList, function ($o1, $o2) {
            return $o1->getTimestamp() > $o2->getTimestamp();
        });
        $newList = new HolidayList();
        foreach ($flatList as $holiday) {
            $newList->add($holiday);
        }

        return $newList;
    }
}
