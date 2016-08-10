<?php

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class TimestampFormatter implements HolidayFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = [])
    {
        return $holiday->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        /**
         * @var Holiday $holiday
         */
        foreach ($holidayList->getFlatArray() as $holiday) {
            $result[] = $holiday->getTimestamp();
        }

        return $result;
    }
}
