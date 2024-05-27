<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Portugal;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Portugal implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $isBailoutYear = $this->isBailoutYear($year);
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1975) {
            $holidays->add($this->getFreedomDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if (!$isBailoutYear) {
            $holidays->add($this->getCorpusChristi($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        $holidays->add($this->getPortugalDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if (!$isBailoutYear) {
            $holidays->add($this->getRepublicDay($year, HolidayType::DAY_OFF));
        }
        if (!$isBailoutYear) {
            $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
            $holidays->add($this->getRestorationOfIndependence($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getImmaculateConception($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    protected function isBailoutYear(int $year): bool
    {
        return $year >= 2013 && $year <= 2015;
    }

    protected function getFreedomDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::PORTUGAL_FREEDOM_DAY, "{$year}-04-25", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getPortugalDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::PORTUGAL_DAY, "{$year}-06-10", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getRepublicDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::PORTUGAL_REPUBLIC_DAY, "{$year}-10-05", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getRestorationOfIndependence(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::PORTUGAL_RESTORATION_OF_INDEPENDENCE, "{$year}-12-01", HolidayType::OFFICIAL | $additionalType);
    }
}
