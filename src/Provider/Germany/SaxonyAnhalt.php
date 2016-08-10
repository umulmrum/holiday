<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class SaxonyAnhalt extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    const ID = 'DE-ST';

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return self::ID;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null)
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);
        $holidays->add($this->getEpiphany($year, HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getReformationDay($year, HolidayType::DAY_OFF, $timezone));

        return $holidays;
    }
}
