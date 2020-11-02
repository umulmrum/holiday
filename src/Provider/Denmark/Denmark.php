<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Denmark;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Denmark implements HolidayProviderInterface
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
        $holidays->add($this->getMaundyThursday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getEasterSunday($year, HolidayType::OTHER));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1686) {
            $holidays->add($this->getGeneralPrayerDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1849) {
            if ($year >= 1891 && $year <= 1975) {
                $holidays->add($this->getDanishNationalHoliday($year, HolidayType::HALF_DAY_OFF));
            } else {
                $holidays->add($this->getDanishNationalHoliday($year, HolidayType::OTHER));
            }
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getNewYearsEve($year, HolidayType::OFFICIAL));

        return $holidays;
    }

    private function getDanishNationalHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DANISH_NATIONAL_HOLIDAY, "{$year}-06-05", HolidayType::OFFICIAL | $additionalType);
    }

    private function getGeneralPrayerDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSundayDate = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(
            HolidayName::GENERAL_PRAYER_DAY,
            $easterSundayDate->add(new \DateInterval('P26D')),
            HolidayType::OFFICIAL | HolidayType::RELIGIOUS | $additionalType
        );
    }
}
