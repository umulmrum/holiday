<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Russia;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianOrthodoxHolidaysTrait;

class Russia implements HolidayProviderInterface
{
    use ChristianOrthodoxHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        if ($year <= 1990) {
            return $holidays;
        }

        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        $this->addNewYearHolidays($holidays, $year);
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $this->addDefenderOfTheFatherlandDay($holidays, $year);
        $this->addInternationalWomensDay($holidays, $year);
        $this->addSpringAndLabourDay($holidays, $year);
        $this->addVictoryDay($holidays, $year);
        if ($year >= 1992) {
            $this->addRussiaDay($holidays, $year);
        }
        if ($year >= 2005) {
            $this->addUnityDay($holidays, $year);
        } else {
            $this->addOctoberRevolutionDay($holidays, $year);
        }

        return $holidays;
    }

    private function addNewYearHolidays(HolidayList $holidays, int $year): void
    {
        if ($year >= 2006) {
            $days = [2, 3, 4, 5, 6, 8];
        } else {
            $days = [2];
        }
        foreach ($days as $day) {
            $holidays->add(Holiday::create(
                HolidayName::NEW_YEAR_HOLIDAY,
                "{$year}-01-0{$day}",
                HolidayType::OFFICIAL | HolidayType::DAY_OFF
            ));
        }
    }

    private function addDefenderOfTheFatherlandDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::DEFENDER_OF_THE_FATHERLAND_DAY, "{$year}-02-23", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addInternationalWomensDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getInternationalWomensDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addSpringAndLabourDay(HolidayList $holidays, int $year): void
    {
        if ($year <= 1991) {
            $name = HolidayName::MAY_DAY;
        } else {
            $name = HolidayName::SPRING_AND_LABOUR_DAY;
        }
        $holiday = Holiday::create($name, "{$year}-05-01", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addVictoryDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::VICTORY_DAY, "{$year}-05-09", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addRussiaDay(HolidayList $holidays, int $year): void
    {
        if ($year <= 2001) {
            $name = HolidayName::DECLARATION_OF_SOVEREIGNTY_DAY;
        } else {
            $name = HolidayName::RUSSIA_DAY;
        }
        $holiday = Holiday::create($name, "{$year}-06-12", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addUnityDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::UNITY_DAY, "{$year}-11-04", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    private function addOctoberRevolutionDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::OCTOBER_REVOLUTION_DAY, "{$year}-11-07", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }
}
