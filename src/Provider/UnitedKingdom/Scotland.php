<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\UnitedKingdom;

use DateTime;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Scotland extends UnitedKingdom
{
    use ChristianHolidaysTrait;
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year));
        $holidays->add($this->getNewYearHoliday($year));
        if ($year === 1968) {
            $holidays->add($this->getSterlingCrisis());
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year === 2011) {
            $holidays->add($this->getWeddingOfWilliamAndCatherine());
        }
        $holidays->add($this->getEarlyMayDay($year));
        if ($year === 2023) {
            $holidays->add($this->getCoronationOfCharlesAndCamilla());
        }
        if ($year <= 1967) {
            $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        $holidays->addAll($this->getSpringBankHolidays($year));
        if ($year === 1977) {
            $holidays->add($this->getSilverJubileeBankHoliday());
        }
        if ($year === 1981) {
            $holidays->add($this->getWeddingOfCharlesAndDiana());
        }
        $holidays->add($this->getSummerBankHoliday($year));
        if ($year === 2022) {
            $holidays->add($this->getStateFuneralOfQueenElizabeth());
        }
        if ($year === 1973) {
            $holidays->add($this->getWeddingOfAnneAndMark());
        }
        if ($year >= 2007) {
            $this->addSaintAndrewsDay($holidays, $year);
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $this->addBoxingDay($holidays, $year);
        if ($year === 1999) {
            $holidays->add($this->getYear2kCelebration());
        }

        return $holidays;
    }

    private function getNewYear(int $year): Holiday
    {
        $date = new DateTime("{$year}-01-01");
        $weekday = $date->format('w');
        if ($weekday === '0') {
            $date = "{$year}-01-02";
        } elseif ($weekday === '6') {
            $date = "{$year}-01-04";
        } else {
            $date = "{$year}-01-01";
        }

        return Holiday::create(HolidayName::NEW_YEAR, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getNewYearHoliday(int $year): Holiday
    {
        $date = new DateTime("{$year}-01-02");
        $weekday = $date->format('w');
        if ($weekday === '0' || $weekday === '1') {
            $date = "{$year}-01-03";
        } elseif ($weekday === '6') {
            $date = "{$year}-01-04";
        } else {
            $date = "{$year}-01-02";
        }

        return Holiday::create(HolidayName::NEW_YEAR_HOLIDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getSummerBankHoliday(int $year): Holiday
    {
        $date = (new DateTime("First Monday of {$year}-08"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::SUMMER_BANK_HOLIDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function addSaintAndrewsDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::BOXING_DAY, "{$year}-11-30", HolidayType::OFFICIAL | HolidayType::BANK);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }
}
