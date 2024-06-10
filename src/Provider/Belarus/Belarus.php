<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Belarus;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianOrthodoxHolidaysTrait;

use function array_filter;

class Belarus implements HolidayProviderInterface
{
    use ChristianOrthodoxHolidaysTrait, ChristianHolidaysTrait {
        ChristianOrthodoxHolidaysTrait::getGoodFriday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::calculateEasterSunday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterSunday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterSundayDate insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getEasterMonday insteadof ChristianHolidaysTrait;
        ChristianOrthodoxHolidaysTrait::getWhitSunday insteadof ChristianHolidaysTrait;
        ChristianHolidaysTrait::getChristmasDay insteadof ChristianOrthodoxHolidaysTrait;
        ChristianHolidaysTrait::getChristmasDay as getWesternChristmasDay;
        ChristianOrthodoxHolidaysTrait::getChristmasDay as getEasternChristmasDay;
    }
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        return new HolidayList(array_filter([
            $this->getNewYear($year, HolidayType::DAY_OFF),
            $year >= 2020 ? $this->getNewYear($year, HolidayType::DAY_OFF) : null,
            $this->getEasternChristmasDay($year, HolidayType::DAY_OFF),
            $this->getRadonitsa($year, HolidayType::DAY_OFF),
            $this->getInternationalWomensDay($year, HolidayType::DAY_OFF),
            $this->getLaborDay($year, HolidayType::DAY_OFF),
            $this->getVictoryDay($year, HolidayType::DAY_OFF),
            $this->getIndependenceDay($year, HolidayType::DAY_OFF),
            $this->getOctoberRevolutionDay($year, HolidayType::DAY_OFF),
            $this->getWesternChristmasDay($year, HolidayType::DAY_OFF),
        ]));
    }

    private function getVictoryDay(int $year, int $additionalType = HolidayType::OTHER): ?Holiday
    {
        return $year >= 1945
            ? Holiday::create(HolidayName::VICTORY_DAY, "{$year}-05-09", HolidayType::OFFICIAL | $additionalType)
            : null;
    }

    private function getIndependenceDay(int $year, int $additionalType): ?Holiday
    {
        if ($year <= 1990) {
            return null;
        }

        return $year >= 1996
            ? Holiday::create(HolidayName::BELARUS_INDEPENDENCE_DAY, "{$year}-07-03", HolidayType::OFFICIAL | $additionalType)
            : Holiday::create(HolidayName::BELARUS_INDEPENDENCE_DAY, "{$year}-07-27", HolidayType::OFFICIAL | $additionalType);
    }

    private function getOctoberRevolutionDay(int $year, int $additionalType): ?Holiday
    {
        return $year >= 1995
            ? Holiday::create(HolidayName::OCTOBER_REVOLUTION_DAY, "{$year}-11-07", HolidayType::OFFICIAL | $additionalType)
            : null;
    }
}
