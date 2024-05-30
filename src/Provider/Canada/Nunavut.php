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

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Nunavut extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getVictoriaDay($year, HolidayType::DAY_OFF));
        if ($year >= 2000) {
            $holidays->add($this->getNunavutDay($year));
        }
        $holidays->add($this->getCivicHoliday($year));

        return $holidays;
    }

    protected function getNunavutDay(int $year): Holiday
    {
        if ($year === 2000) {
            $date = "{$year}-04-01";
        } else {
            $date = "{$year}-07-09";
        }

        return Holiday::create(HolidayName::NUNAVUT_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY);
    }
}
