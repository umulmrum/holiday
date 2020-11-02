<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Germany;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;

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
        if (2020 === $year) {
            $holidays->add($this->getVictoryInEuropeDay($year, HolidayType::DAY_OFF));
        }

        return $holidays;
    }
}
