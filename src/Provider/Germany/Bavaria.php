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
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);

        $holidays->add(Holiday::create(HolidayName::AUGSBURGER_FRIEDENSFEST, "{$year}-08-08", HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        if ($year < 1969) {
            $holidays->add($this->getSaintJosephsDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));

        return $holidays;
    }
}
