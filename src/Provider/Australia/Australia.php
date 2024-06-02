<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Australia;

use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Australia implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $this->addNewYear($holidays, $year, HolidayType::DAY_OFF);
        if ($year >= 1946) {
            $this->addAustraliaDay($holidays, $year, HolidayType::DAY_OFF);
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1927) {
            $holidays->add($this->getAnzacDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1937) {
            $holidays->add($this->getKingsBirthday($year, HolidayType::DAY_OFF));
        }
        if ($year === 2022) {
            $holidays->add($this->getNationalDayOfMourningElizabethII(HolidayType::DAY_OFF));
        }
        $this->addChristmasDay($holidays, $year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $this->addBoxingDay($holidays, $year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);

        return $holidays;
    }

    protected function addNewYear(HolidayList $holidays, int $year, int $additionalType = HolidayType::OTHER): void
    {
        $holiday = $this->getNewYear($year, $additionalType);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    protected function addAustraliaDay(HolidayList $holidays, int $year, int $additionalType = HolidayType::OTHER): void
    {
        $holiday = Holiday::create(HolidayName::AUSTRALIA_DAY, "{$year}-01-26", HolidayType::OFFICIAL | $additionalType);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday);
    }

    protected function getAnzacDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ANZAC_DAY, "{$year}-04-25", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getKingsBirthday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(HolidayName::KINGS_BIRTHDAY, new DateTimeImmutable("Second Monday of {$year}-06"), HolidayType::OFFICIAL | $additionalType);
    }

    private function getNationalDayOfMourningElizabethII(int $additionalType): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_DAY_OF_MOURNING, '2022-09-22', HolidayType::OFFICIAL | $additionalType);
    }

    private function addChristmasDay(HolidayList $holidays, int $year, int $additionalType = HolidayType::OTHER): void
    {
        $holiday = $this->getChristmasDay($year, $additionalType);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, null, 2);
    }

    private function addBoxingDay(HolidayList $holidays, int $year, int $additionalType = HolidayType::OTHER): void
    {
        $holiday = $this->getBoxingDay($year, $additionalType);
        $holidays->add($holiday);
        $this->addLaterCompensatoryDay($holidays, $holiday, null, 2);
    }
}
