<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\HolidayList;

interface HolidayFilterInterface
{
    /**
     * Applies a filter algorithm to the $holidayList, so that the result
     * is either reduced in size or sorted afterwards.
     * The filter MUST return a new HolidayList object and MAY NOT modify
     * the passed one.
     *
     * @param HolidayList $holidayList
     * @param array       $options
     *
     * @return HolidayList
     */
    public function filter(HolidayList $holidayList, array $options = []);
}
