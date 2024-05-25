<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Turkey;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

class Turkey implements HolidayProviderInterface
{
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getNationalSovereigntyAndChildrensDay($year));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getCommemorationOfAtatuerkDay($year));
        if ($year >= 1963 && $year <= 1981) {
            $holidays->add($this->getFreedomAndConstitutionDay($year));
        }
        if ($year >= 2017) {
            $holidays->add($this->getDemocracyAndNationalUnityDay($year));
        }
        $holidays->add($this->getVictoryDay($year));
        $this->addRepublicDay($holidays, $year);

        return $holidays;
    }

    protected function getNationalSovereigntyAndChildrensDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_SOVEREIGNTY_AND_CHILDRENS_DAY, "{$year}-04-23", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getCommemorationOfAtatuerkDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::COMMEMORATION_OF_ATATUERK_DAY, "{$year}-05-19", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getFreedomAndConstitutionDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::FREEDOM_AND_CONSTITUTION_DAY, "{$year}-05-27", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getDemocracyAndNationalUnityDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::DEMOCRACY_AND_NATIONAL_UNITY_DAY, "{$year}-07-15", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getVictoryDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::TURKISH_VICTORY_DAY, "{$year}-08-30", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function addRepublicDay(HolidayList $holidays, int $year): void
    {
        $holidays->add(Holiday::create(HolidayName::TURKISH_REPUBLIC_DAY, "{$year}-10-28", HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));
        $holidays->add(Holiday::create(HolidayName::TURKISH_REPUBLIC_DAY, "{$year}-10-29", HolidayType::OFFICIAL | HolidayType::DAY_OFF));
    }
}
