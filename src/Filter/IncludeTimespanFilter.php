<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use DateInterval;
use DateTime;
use umulmrum\Holiday\Model\HolidayList;

class IncludeTimespanFilter implements HolidayFilterInterface
{
    const PARAM_FIRST_DAY = 'include_timespan_filter.first_day';
    const PARAM_LAST_DAY = 'include_timespan_filter.last_day';

    /**
     * @var HolidayFilterInterface
     */
    private $chainedFilter;

    /**
     * @param HolidayFilterInterface $chainedFilter
     */
    public function __construct(HolidayFilterInterface $chainedFilter = null)
    {
        $this->chainedFilter = $chainedFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList, array $options = [])
    {
        if (null !== $this->chainedFilter) {
            $holidayList = $this->chainedFilter->filter($holidayList, $options);
        }

        /**
         * @var DateTime $firstDay
         */
        $firstDay = $options[self::PARAM_FIRST_DAY]->getTimestamp();
        /**
         * @var DateTime $lastDayPlusOne
         */
        $lastDayPlusOne = clone $options[self::PARAM_LAST_DAY];
        $lastDayPlusOne->add(new DateInterval('P1D'));
        $lastDayPlusOne = $lastDayPlusOne->getTimestamp();

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            $timestamp = $holiday->getTimestamp();
            if ($timestamp >= $firstDay && $timestamp < $lastDayPlusOne) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
