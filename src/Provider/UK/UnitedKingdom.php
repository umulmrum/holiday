<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\UK;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class UnitedKingdom implements HolidayProviderInterface
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
        if ($year >= 1994) {
            $holidays->add($this->getMayDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::NO_SCHOOL));
        $holidays->add($this->getBoxingDay($year, HolidayType::NO_SCHOOL));

        return $holidays;
    }

    private function getMayDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("First Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);
        return Holiday::create(HolidayName::MAY_DAY, $date, HolidayType::OFFICIAL | $additionalType);
    }

    protected function getSpringBankHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("Last Monday of {$year}-05"))->format(Holiday::DISPLAY_DATE_FORMAT);
        return Holiday::create(HolidayName::SPRING_BANK_HOLIDAY, $date, HolidayType::BANK | $additionalType);
    }

    protected function getSummerBankHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("Last Monday of {$year}-08"))->format(Holiday::DISPLAY_DATE_FORMAT);
        return Holiday::create(HolidayName::SUMMER_BANK_HOLIDAY, $date, HolidayType::BANK | $additionalType);
    }

    private function getBoxingDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::BOXING_DAY, "{$year}-12-26", HolidayType::DAY_OFF | $additionalType);
    }

}
