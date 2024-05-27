<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Portugal;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

final class Azores extends Portugal
{
    use ChristianHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year >= 1981) {
            $holidays->add($this->getAzoresDay($year, HolidayType::DAY_OFF));
        }

        return $holidays;
    }

    protected function getAzoresDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $baseHoliday = $this->getWhitMonday($year);

        return Holiday::create(HolidayName::AZORES_DAY, $baseHoliday->getSimpleDate(), HolidayType::OFFICIAL | HolidayType::RELIGIOUS | $additionalType);
    }
}
