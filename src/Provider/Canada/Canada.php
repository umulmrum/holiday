<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Canada;

use DateTime;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Canada implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        if ($year === 1952) {
            $holidays->add($this->getNationalDayOfMourningGeorgeVI($year));
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1983) {
            $holidays->add($this->getCanadaDay($year));
        } else {
            $holidays->add($this->getDominionDay($year));
        }
        $holidays->add($this->getLaborDayCanada($year));
        if ($year === 2022) {
            $holidays->add($this->getNationalDayOfMourningElizabethII($year));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 2021) {
            $holidays->add($this->getNationalDayForTruthAndReconciliation($year, HolidayType::PARTIAL_ONLY));
        }
        $holidays->add($this->getThanksgiving($year));
        $holidays->add($this->getRemembranceDay($year));

        return $holidays;
    }

    protected function getNationalDayOfMourningGeorgeVI(int $year): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_DAY_OF_MOURNING, "{$year}-02-15", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getFamilyDay(int $year): Holiday
    {
        $date = new DateTime("Third Monday of {$year}-02");

        return Holiday::createFromDateTime(HolidayName::FAMILY_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getVictoriaDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTime("last monday front of {$year}-05-25");

        return Holiday::createFromDateTime(HolidayName::VICTORIA_DAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    protected function getNationalIndigenousPeopleDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_INDIGENOUS_PEOPLE_DAY, "{$year}-06-21", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getCanadaDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::CANADA_DAY, "{$year}-07-01", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getDominionDay(int $year): Holiday
    {
        return Holiday::create(HolidayName::DOMINION_DAY, "{$year}-07-01", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getCivicHoliday(int $year): Holiday
    {
        $date = new DateTime("First Monday of {$year}-08");

        return Holiday::createFromDateTime(HolidayName::CIVIC_HOLIDAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getLaborDayCanada(int $year): Holiday
    {
        $date = new DateTime("First Monday of {$year}-09");

        return Holiday::createFromDateTime(HolidayName::LABOR_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
    }

    protected function getNationalDayOfMourningElizabethII(int $year): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_DAY_OF_MOURNING, "{$year}-09-22", HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY);
    }

    protected function getNationalDayForTruthAndReconciliation(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_DAY_FOR_TRUTH_AND_RECONCILIATION, "{$year}-09-30", HolidayType::OFFICIAL | HolidayType::DAY_OFF | $additionalType);
    }

    protected function getThanksgiving(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = new DateTime("Second Monday of {$year}-10");

        return Holiday::createFromDateTime(HolidayName::THANKSGIVING_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF | $additionalType);
    }

    protected function getRemembranceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::REMEMBRANCE_DAY, "{$year}-11-11", HolidayType::OFFICIAL | HolidayType::DAY_OFF | $additionalType);
    }
}
