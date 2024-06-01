<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Canada;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class NorthwestTerritories extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED));
        $holidays->add($this->getVictoriaDay($year, HolidayType::DAY_OFF));
        if ($year >= 2001) {
            $holidays->add($this->getNationalIndigenousPeopleDay($year));
        }
        $holidays->add($this->getCivicHoliday($year));
        if ($year >= 2022) {
            $holidays->replaceByNameAndDate($this->getNationalDayForTruthAndReconciliation($year, HolidayType::DAY_OFF));
        }

        return $holidays;
    }
}
