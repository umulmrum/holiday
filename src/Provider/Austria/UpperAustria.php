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

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class UpperAustria extends Austria
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year <= 2003) {
            $holidays->add($this->getLeopoldsDay($year, HolidayType::OFFICIAL | HolidayType::NO_SCHOOL));
        } else {
            $holidays->add($this->getSaintFloriansDay($year, HolidayType::OFFICIAL));
        }

        return $holidays;
    }
}
