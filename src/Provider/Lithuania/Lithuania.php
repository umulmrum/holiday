<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Lithuania;

use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

use function array_filter;

class Lithuania implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        return new HolidayList(array_filter([
            $this->getNewYear($year, HolidayType::DAY_OFF),
            $this->getDayOfRestorationOfTheState($year, HolidayType::DAY_OFF),
            $this->getDayOfRestorationOfIndependence($year, HolidayType::DAY_OFF),
            $this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getLaborDay($year, HolidayType::DAY_OFF),
            $this->getMothersDay($year, HolidayType::DAY_OFF),
            $this->getFathersDay($year, HolidayType::DAY_OFF),
            $this->getMidsummersDay($year, HolidayType::DAY_OFF),
            $this->getStatehoodDay($year, HolidayType::DAY_OFF),
            $this->getAssumptionDay($year, HolidayType::DAY_OFF),
            $this->getAllSaintsDay($year, HolidayType::DAY_OFF),
            $year >= 2020 ? $this->getAllSoulsDay($year, HolidayType::DAY_OFF) : null,
            $this->getChristmasEve($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY),
            $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
        ]));
    }

    protected function getDayOfRestorationOfTheState(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_RESTORATION_OF_THE_STATE_OF_LITHUANIA, "{$year}-02-16", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getDayOfRestorationOfIndependence(int $year, int $additionalType = HolidayType::OTHER): ?Holiday
    {
        return $year >= 1990
            ? Holiday::create(HolidayName::DAY_OF_RESTORATION_OF_INDEPENDENCE_OF_LITHUANIA, "{$year}-03-11", HolidayType::OFFICIAL | $additionalType)
            : null;
    }

    protected function getMidsummersDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::MIDSUMMERS_DAY, "{$year}-06-24", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getMothersDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::MOTHERS_DAY,
            new DateTimeImmutable("First Sunday of {$year}-05"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getFathersDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::FATHERS_DAY,
            new DateTimeImmutable("First Sunday of {$year}-06"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getStatehoodDay(int $year, int $additionalType = HolidayType::OTHER): ?Holiday
    {
        return $year >= 1991
            ? Holiday::create(HolidayName::LITHUANIA_STATEHOOD_DAY, "{$year}-07-06", HolidayType::OFFICIAL | $additionalType)
            : null;
    }
}
