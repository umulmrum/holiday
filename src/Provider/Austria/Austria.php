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

class Austria implements HolidayProviderInterface
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
        $holidays->add($this->getEpiphany($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        $holidays->add($this->getEasterSunday($year, HolidayType::OTHER, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if (($year >= 1919 && $year <= 1932) || $year >= 1945) {
            $holidays->add($this->getAustrianStatesHoliday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        }
        if ($year >= 1934 && $year <= 1944) {
            $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        }
        $holidays->add($this->getWhitSunday($year, HolidayType::OTHER, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if ($year >= 1965) {
            if ($year >= 1967) {
                $holidays->add($this->getAustrianNationalHoliday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
            } else {
                $holidays->add($this->getAustrianNationalHoliday($year, HolidayType::OFFICIAL, $timezone));
            }
        }
        $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getImmaculateConception($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getNewYearsEve($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));

        return $holidays;
    }

    private function getAustrianNationalHoliday(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::AUSTRIAN_NATIONAL_HOLIDAY, new \DateTime(sprintf('%s-10-26', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    private function getAustrianStatesHoliday(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::AUSTRIAN_STATES_HOLIDAY, new \DateTime(sprintf('%s-05-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}
