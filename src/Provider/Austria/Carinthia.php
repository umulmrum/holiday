<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Austria;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Carinthia extends Austria
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getSaintJosephsDay($year, HolidayType::OFFICIAL | HolidayType::NO_SCHOOL | HolidayType::GOVERNMENT_AGENCIES_CLOSED));
        if ($year > 1920) {
            $holidays->add($this->getCarinthianPlebisciteDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }

        return $holidays;
    }

    private function getCarinthianPlebisciteDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::CARINTHIAN_PLEBISCITE_DAY, "{$year}-10-26", HolidayType::OFFICIAL | $additionalType);
    }
}
