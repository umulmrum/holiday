<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Bavaria extends BadenWuerttemberg
{
    use ChristianHolidaysTrait;

    const ID = 'DE-BY';

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

        $holidays->add(new Holiday(HolidayName::AUGSBURGER_FRIEDENSFEST, new DateTime(sprintf('%s-08-08', $year), $timezone), HolidayType::DAY_OFF | HolidayType::PARTIAL_AREA_ONLY));
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_AREA_ONLY, $timezone));

        return $holidays;
    }
}
