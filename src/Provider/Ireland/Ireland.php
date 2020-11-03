<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Ireland;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Ireland implements HolidayProviderInterface
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
        if ($year >= 1903) {
            $this->addSaintPatricksDay($holidays, $year);
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::BANK | HolidayType::NO_SCHOOL));
        if ($year >= 1994) {
            $holidays->add($this->getMayDay($year, HolidayType::DAY_OFF));
        }
        if ($year <= 1973) {
            $holidays->add($this->getWhitMonday($year, HolidayType::DAY_OFF));
        } else {
            $holidays->add($this->getJuneHoliday($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1871) {
            $holidays->add($this->getAugustHoliday($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1977) {
            $holidays->add($this->getOctoberHoliday($year, HolidayType::DAY_OFF));
        }
        $this->addChristmasDay($holidays, $year);
        $this->addSecondChristmasDay($holidays, $year);

        return $holidays;
    }

    private function addNewYear(HolidayList $holidays, $year): void
    {
        $holiday = $this->getNewYear($year, HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, HolidayType::OTHER);
    }

    private function addSaintPatricksDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::SAINT_PATRICKS_DAY, "{$year}-03-17", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, HolidayType::OTHER);
    }

    private function getMayDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("First Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::MAY_DAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getJuneHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("First Monday of {$year}-06"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::JUNE_HOLIDAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getAugustHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("First Monday of {$year}-08"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::AUGUST_HOLIDAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getOctoberHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("Last Monday of {$year}-10"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::OCTOBER_HOLIDAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function addChristmasDay(HolidayList $holidays, $year): void
    {
        $holiday = $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, HolidayType::OTHER, 2);
    }

    private function addSecondChristmasDay(HolidayList $holidays, $year): void
    {
        $holiday = $this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, HolidayType::OTHER, 2);
    }
}
