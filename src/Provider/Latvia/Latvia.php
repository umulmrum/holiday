<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Latvia;

use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryHolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

use function array_filter;

class Latvia implements CompensatoryHolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        return new HolidayList(array_filter([
            $this->getNewYear($year, HolidayType::DAY_OFF),
            $this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY),
            $this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getLaborDay($year, HolidayType::DAY_OFF),
            $this->getRestorationOfIndependenceDay($year, HolidayType::DAY_OFF),
            $this->getMidsummersEve($year, HolidayType::DAY_OFF),
            $this->getMidsummersDay($year, HolidayType::DAY_OFF),
            $this->getProclamationDay($year, HolidayType::DAY_OFF),
            $this->getChristmasEve($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY),
            $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
            $this->getNewYearsEve($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF),
        ]));
    }

    protected function getRestorationOfIndependenceDay(int $year, int $additionalType = HolidayType::OTHER): ?Holiday
    {
        return $year >= 1990
            ? Holiday::create(HolidayName::RESTORATION_OF_INDEPENDENCE_DAY, "{$year}-05-04", HolidayType::OFFICIAL | $additionalType)
            : null;
    }

    protected function getMidsummersEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::MIDSUMMER_EVE, "{$year}-06-23", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getMidsummersDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::MIDSUMMERS_DAY, "{$year}-06-24", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getProclamationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::PROCLAMATION_DAY_OF_THE_REPUBLIC_OF_LATVIA, "{$year}-11-18", HolidayType::OFFICIAL | $additionalType);
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        return [
            new CompensatoryDaysCalculator(
                [
                    HolidayName::RESTORATION_OF_INDEPENDENCE_DAY,
                    HolidayName::PROCLAMATION_DAY_OF_THE_REPUBLIC_OF_LATVIA,
                ],
            ),
        ];
    }
}
