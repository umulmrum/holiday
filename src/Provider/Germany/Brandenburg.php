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
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class Brandenburg extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getEasterSunday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getWhitSunday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getReformationDay($year, HolidayType::DAY_OFF));

        return $holidays;
    }
}
