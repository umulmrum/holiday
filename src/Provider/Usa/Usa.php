<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Usa;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Usa implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $this->addNewYear($holidays, $year);
        if ($year >= 1986) {
            $holidays->add($this->getMartinLutherKingJrDay($year));
        }
        if ($year >= 1879) {
            $holidays->add($this->getWashingtonsBirthday($year));
        }
        if ($year >= 1868) {
            $holidays->add($this->getMemorialDay($year));
        }
        $this->addIndependenceDay($holidays, $year);
        if ($year >= 1894) {
            $holidays->add($this->getLaborDayUsa($year));
        }
        if (1892 === $year || $year >= 1968) {
            $holidays->add($this->getColumbusDay($year));
        }
        if ($year >= 1938 && $year <= 1953) {
            $holidays->add($this->getArmisticeDay($year));
        }
        if ($year >= 1954) {
            $this->addVeteransDay($holidays, $year);
        }
        if ($year >= 1885) {
            $holidays->add($this->getThanksgivingDay($year));
        }
        $this->addChristmasDay($holidays, $year);
        $this->addCompensatoryNewYearForFollowingYear($holidays, $year);

        return $holidays;
    }

    private function addNewYear(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function getMartinLutherKingJrDay(int $year): Holiday
    {
        $date = (new \DateTime("Third Monday of {$year}-01"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::MARTIN_LUTHER_KING_JR_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getWashingtonsBirthday(int $year): Holiday
    {
        if ($year >= 1971) {
            $date = (new \DateTime("Third Monday of {$year}-02"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-02-22";
        }

        return Holiday::create(HolidayName::WASHINGTONS_BIRTHDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getMemorialDay(int $year): Holiday
    {
        if ($year >= 1971) {
            $date = (new \DateTime("Last Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-05-30";
        }

        return Holiday::create(HolidayName::MEMORIAL_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function addIndependenceDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::INDEPENDENCE_DAY, "{$year}-07-04", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function getLaborDayUsa(int $year): Holiday
    {
        $date = (new \DateTime("First Monday of {$year}-09"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::LABOR_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getColumbusDay(int $year): Holiday
    {
        if ($year >= 1971) {
            $date = (new \DateTime("Second Monday of {$year}-10"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-10-12";
        }

        return Holiday::create(HolidayName::COLUMBUS_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function getArmisticeDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::ARMISTICE_DAY, "{$year}-11-11", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function addVeteransDay(HolidayList $holidays, int $year): void
    {
        if ($year >= 1971 && $year <= 1977) {
            $date = (new \DateTime("Fourth Monday of {$year}-10"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-11-11";
        }

        $holiday = Holiday::create(HolidayName::VETERANS_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        if ($year >= 1978) {
            $this->addNearestCompensatoryDay($holidays, $holiday, $year);
        }
    }

    private function getThanksgivingDay(int $year): Holiday
    {
        $date = (new \DateTime("Fourth Thursday of {$year}-11"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::THANKSGIVING_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    private function addChristmasDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }
}
