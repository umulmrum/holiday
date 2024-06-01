<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\CzechRepublic;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class CzechRepublic implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 2000) {
            $holidays->add($this->getRestorationDayOfTheIndependentCzechState($year, HolidayType::DAY_OFF));
        }
        if ($year >= 2016) {
            $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year >= 1951) {
            $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year >= 1992) {
            $holidays->add($this->getVictoryDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1990) {
            $holidays->add($this->getSaintsCyrilAndMethodiusDay($year, HolidayType::DAY_OFF));
            $holidays->add($this->getJanHusDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 2000) {
            $holidays->add($this->getStatehoodDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1988) {
            $holidays->add($this->getIndependentCzechoslovakStateDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 2000) {
            $holidays->add($this->getStruggleForFreedomDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1990) {
            $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year >= 1951) {
            $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }

        return $holidays;
    }

    protected function getRestorationDayOfTheIndependentCzechState(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::RESTORATION_DAY_OF_THE_INDEPENDENT_CZECH_STATE, "{$year}-01-01", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getVictoryDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::VICTORY_DAY, "{$year}-05-08", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getSaintsCyrilAndMethodiusDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINTS_CYRIL_AND_METHODIUS_DAY, "{$year}-07-05", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getJanHusDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::JAN_HUS_DAY, "{$year}-07-06", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getStatehoodDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::STATEHOOD_DAY, "{$year}-09-28", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getIndependentCzechoslovakStateDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INDEPENDENT_CZECHOSLOVAK_STATE_DAY, "{$year}-10-28", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getStruggleForFreedomDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::STRUGGLE_FOR_FREEDOM_DAY, "{$year}-11-17", HolidayType::OFFICIAL | $additionalType);
    }
}
