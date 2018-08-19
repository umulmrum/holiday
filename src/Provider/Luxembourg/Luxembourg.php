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

class Luxembourg implements HolidayProviderInterface
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
        $holidays->add($this->getGoodFriday($year, HolidayType::BANK, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitTuesday($year, HolidayType::OFFICIAL | HolidayType::NO_SCHOOL, $timezone));
        if ($year >= 1947) {
            $holidays->add($this->getGrandDukesOfficialBirthday($year, HolidayType::DAY_OFF, $timezone));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));

        return $holidays;
    }

    private function getGrandDukesOfficialBirthday(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        if ($year < 1962) {
            $date = '%s-01-23';
        } elseif ($year <= 2006) {
            $tempDate = new \DateTime("$year-06-23", $timezone);
            if ('0' === $tempDate->format('w')) {
                $date = '%s-06-24';
            } else {
                $date = '%s-06-23';
            }
        } else {
            $date = '%s-06-23';
        }

        return new Holiday(HolidayName::GRAND_DUKES_OFFICIAL_BIRTHDAY, new \DateTime(sprintf($date, $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    private function getWhitTuesday(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::WHIT_MONDAY, $easterSunday->add(new \DateInterval('P51D')), HolidayType::TRADITIONAL | $additionalType);
    }
}
