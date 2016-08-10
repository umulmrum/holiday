<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class IncludeHolidayNameFilter implements HolidayFilterInterface
{
    const PARAM_HOLIDAY_NAME = 'include_holiday_name_filter.holiday_name';

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
        $holidayName = $options[self::PARAM_HOLIDAY_NAME];
        /**
         * @var Holiday[] $tempList
         */
        $tempList = $holidayList->getList()[$holidayName];
        $newList = new HolidayList();

        foreach ($tempList as $holiday) {
            $newList->add($holiday);
        }

        return $newList;
    }
}
