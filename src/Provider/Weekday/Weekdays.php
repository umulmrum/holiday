<?php

namespace umulmrum\Holiday\Provider\Weekday;

use DateTimeZone;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

abstract class Weekdays implements HolidayProviderInterface
{
    use WeekdayTrait;

    /**
     * @var int
     */
    private $weekday;

    /**
     * @param int $weekday
     */
    public function __construct($weekday)
    {
        $this->weekday = $weekday;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null)
    {
        return $this->getWeekdays($year, $this->weekday, $timezone);
    }
}
