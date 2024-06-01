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

class Quebec extends Canada
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getGoodFriday($year, HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        if ($year >= 2003) {
            $holidays->add($this->getNationalPatriotsDay($year));
        }
        if ($year >= 1925) {
            $holidays->add($this->getSaintJeanBaptisteDay($year));
        }
        $holidays->removeByName(HolidayName::REMEMBRANCE_DAY);

        return $holidays;
    }

    protected function getNationalPatriotsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTime("last monday front of {$year}-05-25");

        return Holiday::createFromDateTime(HolidayName::NATIONAL_PATRIOTS_DAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    protected function getSaintJeanBaptisteDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINT_JEAN_BAPTISTE_DAY, "{$year}-06-24", HolidayType::OFFICIAL | $additionalType);
    }
}
