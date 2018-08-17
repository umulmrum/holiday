<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Germany;

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Bavaria extends BadenWuerttemberg
{
    use ChristianHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);

        $holidays->add(new Holiday(HolidayName::AUGSBURGER_FRIEDENSFEST, new \DateTime(sprintf('%s-08-08', $year), $timezone), HolidayType::DAY_OFF | HolidayType::PARTIAL_AREA_ONLY));
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_AREA_ONLY, $timezone));

        return $holidays;
    }
}
