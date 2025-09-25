<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Norway;

use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Norway implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();

        // Public holidays (with a day off)
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getPalmSunday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getMaundyThursday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::DAY_OFF | HolidayType::OFFICIAL | HolidayType::RELIGIOUS));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getConstitutionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitSunday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::RELIGIOUS | HolidayType::DAY_OFF));

        // Traditional days as well as some other days
        $holidays->add($this->getSamiNationalDay($year, HolidayType::OFFICIAL));
        $holidays->add($this->getInternationalWomensDay($year, HolidayType::TRADITIONAL));
        $holidays->add($this->getMidsummersEve($year, HolidayType::TRADITIONAL));
        $holidays->add($this->getHalloween($year, HolidayType::TRADITIONAL));
        $holidays->add($this->getNorwegianAllSaintsDay($year, HolidayType::RELIGIOUS));
        $holidays->add($this->getChristmasEve($year, HolidayType::RELIGIOUS | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getNewYearsEve($year, HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY));

        // Advent Sundays
        $holidays->add($this->getAdventSunday($year, 1, HolidayName::ADVENT_SUNDAY_1));
        $holidays->add($this->getAdventSunday($year, 2, HolidayName::ADVENT_SUNDAY_2));
        $holidays->add($this->getAdventSunday($year, 3, HolidayName::ADVENT_SUNDAY_3));
        $holidays->add($this->getAdventSunday($year, 4, HolidayName::ADVENT_SUNDAY_4));

        // Offisielle flaggdager (uten duplikater)
        $flagDays = $this->getOfficialFlagDays($year);
        foreach ($flagDays as $flagDay) {
            $holidays->add($flagDay);
        }

        return $holidays;
    }

    protected function getConstitutionDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::NORWAY_CONSTITUTION_DAY, "{$year}-05-17", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getSamiNationalDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::NORWAY_SAMI_DAY, "{$year}-02-06", HolidayType::OFFICIAL | HolidayType::OTHER);
    }

    protected function getNorwegianAllSaintsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTimeImmutable("{$year}-11-01 this sunday");

        return Holiday::createFromDateTime(HolidayName::ALL_SAINTS_DAY, $date, HolidayType::TRADITIONAL | $additionalType);
    }

    protected function getMidsummersEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::MIDSUMMER_EVE, "{$year}-06-23", HolidayType::TRADITIONAL | $additionalType);
    }

    protected function getAdventSunday(int $year, int $adventNumber, string $holidayName): Holiday
    {
        $christmasDay = new DateTimeImmutable("{$year}-12-25");
        $daysToSubtract = (4 - $adventNumber) * 7;
        $adventSunday = $christmasDay->modify("-{$daysToSubtract} days")->modify("last sunday");
        return Holiday::create($holidayName, $adventSunday->format('Y-m-d'), HolidayType::RELIGIOUS);
    }

    protected function getOfficialFlagDays(int $year): HolidayList
    {
        $flagDays = new HolidayList();
        $flagDays->add(Holiday::create(HolidayName::PRINSESS_INGRID_ALEXANDRAS_BIRTHDAY, "{$year}-01-21", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::KING_HARALD_VS_BIRTHDAY, "{$year}-02-21", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::LIBERATION_DAY, "{$year}-05-08", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::UNION_DISSOLUTION, "{$year}-06-07", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::QUEEN_SONJAS_BIRTHDAY, "{$year}-07-04", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::CROWN_PRINCE_HAAKON_MAGNUS_BIRTHDAY, "{$year}-07-20", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::OLSOK_DAY, "{$year}-07-29", HolidayType::OFFICIAL));
        $flagDays->add(Holiday::create(HolidayName::CROWN_PRINCESS_METTE_MARITS_BIRTHDAY, "{$year}-08-19", HolidayType::OFFICIAL));

        // Stortingsvalgdagen (må beregnes dynamisk, men dette er en kompleks oppgave som krever ekstra logikk)
        // For enkelthets skyld kan du legge til en placeholder her, og implementere den dynamiske beregningen senere
        // $flagDays->add($this->getStortingsvalgdagen($year, HolidayType::OFFICIAL));

        return $flagDays;
    }
}
