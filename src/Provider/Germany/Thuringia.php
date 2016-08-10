<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class Thuringia extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    const ID = 'DE-TH';

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
        $holidays->add($this->getCorpusChristi($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_AREA_ONLY, $timezone));
        $holidays->add($this->getReformationDay($year, HolidayType::DAY_OFF, $timezone));

        return $holidays;
    }
}
