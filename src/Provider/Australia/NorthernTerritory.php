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
use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class NorthernTerritory extends Australia
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getEasterSaturday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getMayDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getPicnicDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));
        $holidays->add($this->getNewYearsEve($year, HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF));

        return $holidays;
    }

    protected function getMayDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::MAY_DAY,
            new DateTimeImmutable("First Monday of {$year}-05"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    protected function getPicnicDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::PICNIC_DAY,
            new DateTimeImmutable("First Monday of {$year}-08"),
            HolidayType::OFFICIAL | $additionalType,
        );
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        return [
            ...parent::getCompensatoryDaysCalculators($year),
            new CompensatoryDaysCalculator([HolidayName::ANZAC_DAY]),
        ];
    }
}
