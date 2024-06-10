<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Bulgaria;

use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryHolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianOrthodoxHolidaysTrait;

class Bulgaria implements CompensatoryHolidayProviderInterface
{
    use ChristianHolidaysTrait, ChristianOrthodoxHolidaysTrait {
        ChristianHolidaysTrait::getChristmasDay insteadof ChristianOrthodoxHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::calculateEasterSunday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterSundayDate insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getGoodFriday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterSunday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterMonday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getWhitSunday insteadof ChristianHolidaysTrait;
    }
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::DAY_OFF));
        $holidays->add($this->getLiberationDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getSaintGeorgesDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEducationDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getUnificationDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getIndependenceDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getNationalAwakeningDay($year, HolidayType::NO_SCHOOL));
        $holidays->add($this->getChristmasEve($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    protected function getLiberationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::LIBERATION_DAY, "{$year}-03-03", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getEducationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::EDUCATION_DAY, "{$year}-05-24", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getUnificationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::UNIFICATION_DAY, "{$year}-09-06", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getIndependenceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INDEPENDENCE_DAY, "{$year}-09-22", HolidayType::OFFICIAL | $additionalType);
    }

    protected function getNationalAwakeningDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::NATIONAL_AWAKENING_DAY, "{$year}-11-01", HolidayType::OFFICIAL | $additionalType);
    }

    public function getCompensatoryDaysCalculators(int $year): array
    {
        if ($year <= 2016) {
            return [];
        }

        return [
            new CompensatoryDaysCalculator(
                [
                    HolidayName::NEW_YEAR,
                    HolidayName::LIBERATION_DAY,
                    HolidayName::LABOR_DAY,
                    HolidayName::SAINT_GEORGES_DAY,
                    HolidayName::EDUCATION_DAY,
                    HolidayName::UNIFICATION_DAY,
                    HolidayName::INDEPENDENCE_DAY,
                    HolidayName::NATIONAL_AWAKENING_DAY,
                    HolidayName::CHRISTMAS_EVE,
                    HolidayName::CHRISTMAS_DAY,
                    HolidayName::SECOND_CHRISTMAS_DAY,
                ],
            ),
        ];
    }
}
