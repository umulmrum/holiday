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

class IncludeWeekdayFilter implements HolidayFilterInterface
{
    const PARAM_WEEK_DAY = 'include_week_day_filter.week_day';

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
        $weekday = $options[self::PARAM_WEEK_DAY];

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            if ((int) $holiday->getFormattedDate('w') === $weekday) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
