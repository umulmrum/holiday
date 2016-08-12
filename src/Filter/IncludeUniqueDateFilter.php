<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class IncludeUniqueDateFilter implements HolidayFilterInterface
{
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
        $foundTimestamps = [];

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            if (!isset($foundTimestamps[$holiday->getTimestamp()])) {
                $newList->add($holiday);
                $foundTimestamps[$holiday->getTimestamp()] = 'x';
            }
        }

        return $newList;
    }
}
