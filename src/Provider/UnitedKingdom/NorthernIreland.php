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

use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

class NorthernIreland extends UnitedKingdom
{
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getSaintPatricksDay($year));
        $holidays->add($this->getBattleOfTheBoyne($year));

        return $holidays;
    }

    private function getSaintPatricksDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::SAINT_PATRICKS_DAY, "{$year}-03-17", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getBattleOfTheBoyne(int $year): Holiday
    {
        return Holiday::create(HolidayName::BATTLE_OF_THE_BOYNE, "{$year}-07-12", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        return [
            ...parent::getCompensatoryDaysCalculators($year),
            new CompensatoryDaysCalculator(
                [
                    HolidayName::SAINT_PATRICKS_DAY,
                    HolidayName::BATTLE_OF_THE_BOYNE,
                ]
            ),
        ];
    }
}
