<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

final class ApplyTimezoneFilter implements HolidayFilterInterface
{
    /**
     * @var \DateTimeZone
     */
    private $dateTimeZone;

    public function __construct(\DateTimeZone $dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    public function filter(HolidayList $holidayList): HolidayList
    {
        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            $newList->add(new Holiday(
                $holiday->getName(),
                \DateTime::createFromFormat(Holiday::DATE_FORMAT, $holiday->getFormattedDate('Y-m-d'), $this->dateTimeZone),
                $holiday->getType()
            ));
        }

        return $newList;
    }
}