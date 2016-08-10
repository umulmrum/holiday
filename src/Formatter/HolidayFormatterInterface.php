<?php

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

interface HolidayFormatterInterface
{
    /**
     * @param Holiday $holiday
     * @param array   $options
     *
     * @return int|string
     */
    public function format(Holiday $holiday, array $options = []);

    /**
     * @param HolidayList $holidayList
     * @param array       $options
     *
     * @return int[]|string[]
     */
    public function formatList(HolidayList $holidayList, array $options = []);
}
