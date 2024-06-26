<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Germany;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Bavaria extends Germany
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);

        $holidays->add($this->getEpiphany($year, HolidayType::DAY_OFF));
        $holidays->add($this->getCorpusChristi($year, HolidayType::DAY_OFF));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::DAY_OFF));
        $holidays->add(Holiday::create(HolidayName::AUGSBURGER_FRIEDENSFEST, "{$year}-08-08", HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        if ($year < 1969) {
            $holidays->add($this->getSaintJosephsDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));

        return $holidays;
    }
}
