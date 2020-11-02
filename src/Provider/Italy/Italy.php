<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Italy;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use Umulmrum\Holiday\Provider\Weekday\WeekdayTrait;

class Italy implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use WeekdayTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList($this->getWeekdays($year, Weekday::SUNDAY, HolidayType::DAY_OFF));
        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        if ($year <= 1977 || $year >= 1985) {
            $holidays->add($this->getEpiphany($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1997) {
            $holidays->add($this->getTricolourDay($year));
        }
        if ($year >= 2001) {
            $holidays->add($this->getInternationalHolocaustRemembranceDay($year));
        }
        if (\in_array($year, [1911, 1961, 2011], true)) {
            $holidays->add($this->getAnniversaryOfTheUnificationOfItaly($year, HolidayType::DAY_OFF));
        }
        if ($year <= 1976) {
            $holidays->add($this->getSaintJosephsDay($year, HolidayType::DAY_OFF));
        }
        if (1946 === $year || $year >= 1950) {
            $holidays->add($this->getLiberationDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getEasterSunday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::DAY_OFF));
        if ($year <= 1977) {
            $holidays->add($this->getAscension($year, HolidayType::DAY_OFF));
        }
        if ($year <= 1977) {
            $holidays->add($this->getCorpusChristi($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1946) { // Established after WW2 as a public holiday, but don't know when exactly.
            $holidays->add($this->getLaborDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1946) {
            $holidays->add($this->getRepublicDay($year, HolidayType::DAY_OFF));
        }
        if ($year <= 1976) {
            $holidays->add($this->getFeastofSaintsPeterAndPaul($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getImmaculateConception($year, HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getAnniversaryOfTheUnificationOfItaly(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ANNIVERSARY_OF_THE_UNIFICATION_OF_ITALY, "{$year}-03-17", HolidayType::OFFICIAL | $additionalType);
    }

    private function getInternationalHolocaustRemembranceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INTERNATIONAL_HOLOCAUST_REMEMBRANCE_DAY, "{$year}-01-27", HolidayType::OFFICIAL | $additionalType);
    }

    private function getLiberationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::LIBERATION_DAY, "{$year}-04-25", HolidayType::OFFICIAL | $additionalType);
    }

    private function getRepublicDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        if ($year >= 1977 && $year <= 2000) {
            $date = (new \DateTime("First Sunday of {$year}-06"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-06-02";
        }

        return Holiday::create(HolidayName::REPUBLIC_DAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getTricolourDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::TRICOLOUR_DAY, "{$year}-01-07", HolidayType::OFFICIAL | $additionalType);
    }
}
