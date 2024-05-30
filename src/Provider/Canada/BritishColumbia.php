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

class BritishColumbia extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getVictoriaDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getBritishColumbiaDay($year));
        if ($year >= 2023) {
            $holidays->replaceByNameAndDate($this->getNationalDayForTruthAndReconciliation($year, HolidayType::DAY_OFF));
        }

        return $holidays;
    }

    protected function getBritishColumbiaDay(int $year): Holiday
    {
        $date = new DateTime("First Monday of {$year}-08");

        return Holiday::createFromDateTime(HolidayName::BRITISH_COLUMBIA_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
