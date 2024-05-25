<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\UnitedKingdom;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;

class NorthernIreland extends UnitedKingdom
{
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $this->addSaintPatricksDay($holidays, $year);
        $this->addBattleOfTheBoyne($holidays, $year);

        return $holidays;
    }

    private function addSaintPatricksDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::SAINT_PATRICKS_DAY, "{$year}-03-17", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addBattleOfTheBoyne(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::BATTLE_OF_THE_BOYNE, "{$year}-07-12", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }
}
