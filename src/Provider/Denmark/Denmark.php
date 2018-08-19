<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Austria;

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Denmark implements HolidayProviderInterface
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
        $holidays->add($this->getMaundyThursday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        $holidays->add($this->getEasterSunday($year, HolidayType::OTHER, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if ($year >= 1686) {
            $holidays->add($this->getGeneralPrayerDay($year, HolidayType::DAY_OFF, $timezone));
        }
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if ($year >= 1849) {
            if ($year >= 1891 && $year <= 1975) {
                $holidays->add($this->getDanishNationalHoliday($year, HolidayType::HALF_DAY_OFF, $timezone));
            } else {
                $holidays->add($this->getDanishNationalHoliday($year, HolidayType::OTHER, $timezone));
            }
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getNewYearsEve($year, HolidayType::OFFICIAL, $timezone));

        return $holidays;
    }

    private function getDanishNationalHoliday(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::DANISH_NATIONAL_HOLIDAY, new \DateTime(sprintf('%s-06-05', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    private function getGeneralPrayerDay(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        $easterSundayDate = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::GENERAL_PRAYER_DAY, $easterSundayDate->add(new \DateInterval('P26D')), HolidayType::OFFICIAL | HolidayType::RELIGIOUS | $additionalType);
    }
}
