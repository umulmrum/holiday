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
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitSunday($year, HolidayType::OFFICIAL, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if ($year >= 1990) {
            $holidays->add($this->getGermanUnityDay($year, $timezone));
        }
        if (1954 <= $year && $year <= 1990) {
            $holidays->add($this->getOldGermanUnityDay($year, $timezone));
        }
        if (2017 === $year) {
            $holidays->add($this->getReformationDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        } else {
            $holidays->add($this->getReformationDay($year, HolidayType::OFFICIAL, $timezone));
        }
        if ($year <= 1994) {
            $holidays->add($this->getRepentanceAndPrayerDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        } else {
            $holidays->add($this->getRepentanceAndPrayerDay($year, HolidayType::OFFICIAL, $timezone));
        }

        return $holidays;
    }

    private function getGermanUnityDay(int $year, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::GERMAN_UNITY_DAY, new \DateTime(sprintf('%s-10-03', $year), $timezone), HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getOldGermanUnityDay(int $year, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::GERMAN_UNITY_DAY, new \DateTime(sprintf('%s-06-17', $year), $timezone), HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
