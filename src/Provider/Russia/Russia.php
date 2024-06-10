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

use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryHolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianOrthodoxHolidaysTrait;

class Russia implements CompensatoryHolidayProviderInterface
{
    use ChristianOrthodoxHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        if ($year <= 1990) {
            return $holidays;
        }

        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        $this->addNewYearHolidays($holidays, $year);
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getDefenderOfTheFatherlandDay($year));
        $holidays->add($this->getInternationalWomensDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSpringAndLabourDay($year));
        $holidays->add($this->getVictoryDay($year));
        if ($year >= 1992) {
            $holidays->add($this->getRussiaDay($year));
        }
        if ($year >= 2005) {
            $holidays->add($this->getUnityDay($year));
        } else {
            $holidays->add($this->getOctoberRevolutionDay($year));
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

    private function getDefenderOfTheFatherlandDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::DEFENDER_OF_THE_FATHERLAND_DAY, "{$year}-02-23", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getSpringAndLabourDay(int $year): Holiday
    {
        if ($year <= 1991) {
            $name = HolidayName::MAY_DAY;
        } else {
            $name = HolidayName::SPRING_AND_LABOUR_DAY;
        }

        return Holiday::create($name, "{$year}-05-01", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getVictoryDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::VICTORY_DAY, "{$year}-05-09", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getRussiaDay(int $year): Holiday
    {
        if ($year <= 2001) {
            $name = HolidayName::DECLARATION_OF_SOVEREIGNTY_DAY;
        } else {
            $name = HolidayName::RUSSIA_DAY;
        }

        return Holiday::create($name, "{$year}-06-12", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getUnityDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::UNITY_DAY, "{$year}-11-04", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getOctoberRevolutionDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::OCTOBER_REVOLUTION_DAY, "{$year}-11-07", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        return [
            new CompensatoryDaysCalculator(
                [
                    HolidayName::DEFENDER_OF_THE_FATHERLAND_DAY,
                    HolidayName::INTERNATIONAL_WOMENS_DAY,
                    HolidayName::MAY_DAY,
                    HolidayName::SPRING_AND_LABOUR_DAY,
                    HolidayName::VICTORY_DAY,
                    HolidayName::DECLARATION_OF_SOVEREIGNTY_DAY,
                    HolidayName::RUSSIA_DAY,
                    HolidayName::UNITY_DAY,
                    HolidayName::OCTOBER_REVOLUTION_DAY,
                ],
            ),
        ];
    }
}
