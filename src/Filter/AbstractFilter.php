<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

/**
 * AbstractFilter simplifies implementing filter classes by reducing efforts to implementing a method isIncluded that
 * states if an element should stay in the holiday list or not. Not all imaginable filters are possible with this
 * mechanism - implement HolidayFilterInterface for filters that require access to the complete holiday list.
 */
abstract class AbstractFilter implements HolidayFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): void
    {
        $count = $holidayList->count();
        for ($index = $count - 1; $index >= 0; --$index) {
            if (false === $this->isIncluded($holidayList->getList()[$index])) {
                $holidayList->removeByIndex($index);
            }
        }
    }

    /**
     * Returns true if the passed $holiday should be kept in the filtered holiday list, or false if it is to be removed.
     */
    abstract protected function isIncluded(Holiday $holiday): bool;
}
