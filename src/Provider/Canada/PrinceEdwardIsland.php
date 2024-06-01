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

use DateTime;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class PrinceEdwardIsland extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year >= 2009) {
            $holidays->add($this->getIslanderDay($year));
        }
        if ($year >= 2022) {
            $holidays->replaceByNameAndDate($this->getNationalDayForTruthAndReconciliation($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getThanksgiving($year, HolidayType::PARTIAL_ONLY));

        return $holidays;
    }

    protected function getIslanderDay(int $year): Holiday
    {
        if ($year === 2009) {
            $date = new DateTime("Second Monday of {$year}-02");
        } else {
            $date = new DateTime("Third Monday of {$year}-02");
        }

        return Holiday::createFromDateTime(HolidayName::NOVA_SCOTIA_HERITAGE_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
