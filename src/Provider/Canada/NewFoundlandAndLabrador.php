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

class NewFoundlandAndLabrador extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getVictoriaDay($year, HolidayType::GOVERNMENT_AGENCIES_CLOSED));
        if ($year >= 1917) {
            $holidays->add($this->getMemorialDay($year));
        }
        $holidays->add($this->getThanksgiving($year, HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getBoxingDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));

        return $holidays;
    }

    protected function getMemorialDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::CANADA_MEMORIAL_DAY, "{$year}-07-01", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
