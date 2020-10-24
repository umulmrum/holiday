<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Germany;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class Berlin extends Germany
{
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        if ($year >= 2019) {
            $holidays->add($this->getInternationalWomensDay($year, HolidayType::DAY_OFF));
        }
        if ($year === 2020) {
            $holidays->add($this->getVictoryInEuropeDay($year, HolidayType::DAY_OFF));
        }

        return $holidays;
    }
}
