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

class Saskatchewan extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year >= 2007) {
            $holidays->add($this->getFamilyDay($year));
        }
        $holidays->add($this->getVictoriaDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getSaskatchewanDay($year));

        return $holidays;
    }

    protected function getSaskatchewanDay(int $year): Holiday
    {
        $date = new DateTime("First Monday of {$year}-08");

        return Holiday::createFromDateTime(HolidayName::SASKATCHEWAN_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
