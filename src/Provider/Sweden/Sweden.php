<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Sweden;

use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Sweden implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function __construct(
        protected readonly bool $includeDeFactoHalfHolidays = true,
        protected readonly bool $includeDeFactoFullHolidays = true,
    ) {}

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoHalfHolidays) {
            $holidays->add($this->getTwelfthNight($year, HolidayType::HALF_DAY_OFF | HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getEpiphany($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoHalfHolidays) {
            $holidays->add($this->getWalpurgisNight($year, HolidayType::HALF_DAY_OFF | HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getNationalDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getWhitSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoFullHolidays) {
            $holidays->add($this->getMidsummerEve($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getMidsummersDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoHalfHolidays) {
            $holidays->add($this->getSwedishAllSaintsEve($year, HolidayType::HALF_DAY_OFF | HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getSwedishAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoFullHolidays) {
            $holidays->add($this->getChristmasEve($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($this->includeDeFactoFullHolidays) {
            $holidays->add($this->getNewYearsEve($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }

        return $holidays;
    }

    protected function getTwelfthNight(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::TWELFTH_NIGHT, "{$year}-01-05", HolidayType::RELIGIOUS | $additionalType);
    }

    protected function getWalpurgisNight(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::WALPURGIS_NIGHT, "{$year}-04-30", HolidayType::TRADITIONAL | $additionalType);
    }

    protected function getNationalDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SWEDEN_NATIONAL_DAY, "{$year}-06-06", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getMidsummerEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTimeImmutable("{$year}-06-19 this friday");

        return Holiday::createFromDateTime(HolidayName::MIDSUMMER_EVE, $date, HolidayType::TRADITIONAL | $additionalType);
    }

    protected function getMidsummersDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTimeImmutable("{$year}-06-20 this saturday");

        return Holiday::createFromDateTime(HolidayName::MIDSUMMERS_DAY, $date, HolidayType::TRADITIONAL | $additionalType);
    }

    protected function getSwedishAllSaintsEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTimeImmutable("{$year}-10-30 this friday");

        return Holiday::createFromDateTime(HolidayName::ALL_SAINTS_EVE, $date, HolidayType::RELIGIOUS | $additionalType);
    }

    protected function getSwedishAllSaintsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTimeImmutable("{$year}-10-31 this saturday");

        return Holiday::createFromDateTime(HolidayName::ALL_SAINTS_DAY, $date, HolidayType::RELIGIOUS | $additionalType);
    }
}
