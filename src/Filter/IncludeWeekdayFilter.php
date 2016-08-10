<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
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
        /**
         * @var Holiday $holiday
         */
        $newList = new HolidayList();
        foreach ($holidayList->getList() as $index => $holidays) {
            foreach ($holidays as $holiday) {
                if ((int) $holiday->getFormattedDate('w') === $weekday) {
                    $newList->add($holiday);
                }
            }
        }

        return $newList;
    }
}
