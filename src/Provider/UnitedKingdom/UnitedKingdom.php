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
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class UnitedKingdom implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $this->addNewYear($holidays, $year);
        if ($year === 1968) {
            $holidays->add($this->getSterlingCrisis());
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year === 2011) {
            $holidays->add($this->getWeddingOfWilliamAndCatherine());
        }
        if ($year >= 1978) {
            $holidays->add($this->getEarlyMayDay($year));
        }
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
        $this->addChristmasDay($holidays, $year);
        $this->addBoxingDay($holidays, $year);
        if ($year === 1999) {
            $holidays->add($this->getYear2kCelebration());
        }

        return $holidays;
    }

    private function addNewYear(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getNewYear($year, HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, HolidayType::OTHER);
    }

    protected function getSterlingCrisis(): Holiday
    {
        return Holiday::create(HolidayName::STERLING_CRISIS, '1968-03-15', HolidayType::OFFICIAL | HolidayType::BANK);
    }

    protected function getWeddingOfWilliamAndCatherine(): Holiday
    {
        return Holiday::create(HolidayName::WEDDING_OF_WILLIAM_AND_CATHERINE, '2011-04-29', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getEarlyMayDay(int $year): Holiday
    {
        if ($year === 2020) {
            return Holiday::create(HolidayName::MAY_DAY, '2020-05-08', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        }
        if ($year === 1995) {
            return Holiday::create(HolidayName::MAY_DAY, '1995-05-08', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        }

        $date = (new DateTime("First Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::MAY_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getCoronationOfCharlesAndCamilla(): Holiday
    {
        return Holiday::create(HolidayName::CORONATION_OF_CHARLES_AND_CAMILLA, '2023-05-08', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getSpringBankHolidays(int $year): HolidayList
    {
        $holidayList = new HolidayList();
        if ($year === 2022) {
            $holidayList->add(Holiday::create(HolidayName::SPRING_BANK_HOLIDAY, '2022-06-02', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidayList->add(Holiday::create(HolidayName::PLATINUM_JUBILEE_BANK_HOLIDAY, '2022-06-03', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } elseif ($year === 2012) {
            $holidayList->add(Holiday::create(HolidayName::SPRING_BANK_HOLIDAY, '2012-06-04', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidayList->add(Holiday::create(HolidayName::DIAMOND_JUBILEE_BANK_HOLIDAY, '2012-06-05', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } elseif ($year === 2002) {
            $holidayList->add(Holiday::create(HolidayName::SPRING_BANK_HOLIDAY, '2002-06-04', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidayList->add(Holiday::create(HolidayName::GOLDEN_JUBILEE_BANK_HOLIDAY, '2002-06-02', HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } else {
            $date = (new DateTime("Last Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);
            $holidayList->add(Holiday::create(HolidayName::SPRING_BANK_HOLIDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }

        return $holidayList;
    }

    protected function getSilverJubileeBankHoliday(): Holiday
    {
        return Holiday::create(HolidayName::SILVER_JUBILEE_BANK_HOLIDAY, '1977-07-07', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getWeddingOfCharlesAndDiana(): Holiday
    {
        return Holiday::create(HolidayName::WEDDING_OF_CHARLES_AND_DIANA, '1981-07-29', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getSummerBankHoliday(int $year): Holiday
    {
        if ($year === 1968) {
            $date = '1968-09-02';
        } elseif ($year === 1969) {
            $date = '1969-09-01';
        } elseif ($year >= 1965) {
            $date = (new DateTime("Last Monday of {$year}-08"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = (new DateTime("First Monday of {$year}-08"))->format(Holiday::DISPLAY_DATE_FORMAT);
        }
        return Holiday::create(HolidayName::SUMMER_BANK_HOLIDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getStateFuneralOfQueenElizabeth(): Holiday
    {
        return Holiday::create(HolidayName::STATE_FUNERAL_OF_QUEEN_ELIZABETH, "2022-09-19", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getWeddingOfAnneAndMark(): Holiday
    {
        return Holiday::create(HolidayName::WEDDING_OF_ANNE_AND_MARK, '1973-11-14', HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function addChristmasDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, null, 2);
    }

    private function addBoxingDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getBoxingDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, null, 2);
    }

    protected function getYear2kCelebration(): Holiday
    {
        return Holiday::create(HolidayName::YEAR_2K_CELEBRATION, "1999-12-31", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }
}
