<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Poland;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Poland implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 2011) {
            $holidays->add($this->getEpiphany($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getMayDay($year, HolidayType::DAY_OFF));
        if ($year >= 1990 || ($year >= 1919 && $year <= 1946)) {
            $holidays->add($this->getConstitutionDay($year, HolidayType::DAY_OFF));
        }
        if ($year >= 1945 && $year <= 2014) {
            $holidays->add($this->getVictoryDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getWhitSunday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getCorpusChristi($year, HolidayType::DAY_OFF));
        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF));
        if ($year >= 1992 || ($year >= 1923 && $year <= 1946)) {
            $holidays->add($this->getPolishArmedForcesDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAllSaintsDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getAllSoulsDay($year, HolidayType::NO_SCHOOL));
        if ($year >= 1989 || ($year >= 1937 && $year <= 1946)) {
            $holidays->add($this->getIndependenceDay($year, HolidayType::NO_SCHOOL));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::NO_SCHOOL));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::NO_SCHOOL));

        return $holidays;
    }

    private function getMayDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::MAY_DAY, "{$year}-05-01", HolidayType::OFFICIAL | $additionalType);
    }

    private function getConstitutionDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::CONSTITUTION_DAY, "{$year}-05-03", HolidayType::OFFICIAL | $additionalType);
    }

    private function getVictoryDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::VICTORY_DAY, "{$year}-05-09", HolidayType::OFFICIAL | $additionalType);
    }

    private function getPolishArmedForcesDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::POLISH_ARMED_FORCES_DAY, "{$year}-08-15", HolidayType::OFFICIAL | $additionalType);
    }

    private function getIndependenceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INDEPENDENCE_DAY, "{$year}-11-11", HolidayType::OFFICIAL | $additionalType);
    }
}
