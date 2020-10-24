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

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class Germany implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitSunday($year, HolidayType::OFFICIAL));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1990) {
            $holidays->add($this->getGermanUnityDay($year));
        }
        if (1954 <= $year && $year <= 1990) {
            $holidays->add($this->getOldGermanUnityDay($year));
        }
        if (2017 === $year) {
            $holidays->add($this->getReformationDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } else {
            $holidays->add($this->getReformationDay($year, HolidayType::OFFICIAL));
        }
        if ($year <= 1994) {
            $holidays->add($this->getRepentanceAndPrayerDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } else {
            $holidays->add($this->getRepentanceAndPrayerDay($year, HolidayType::OFFICIAL));
        }
        $holidays->add($this->getChristmasEve($year, HolidayType::BANK));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getNewYearsEve($year, HolidayType::BANK));

        return $holidays;
    }

    private function getGermanUnityDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::GERMAN_UNITY_DAY, sprintf('%s-10-03', $year), HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getOldGermanUnityDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::GERMAN_UNITY_DAY, sprintf('%s-06-17', $year), HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
