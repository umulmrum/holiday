<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Switzerland;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class AppenzellInnerrhoden extends Switzerland
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getCorpusChristi($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSaintMauriceDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getImmaculateConception($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }
}
