<?php

namespace umulmrum\Holiday\Provider\Weekday;

use DateTimeZone;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

class Weekdays implements HolidayProviderInterface
{
    use WeekdayTrait;

    const ID = 'WEEKDAY';
    /**
     * @var int
     */
    private $weekday;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return self::ID;
    }

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
