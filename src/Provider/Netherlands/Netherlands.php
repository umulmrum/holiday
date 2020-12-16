<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Netherlands;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Netherlands implements HolidayProviderInterface
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
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1891 && $year < 2014) {
            $holidays->add($this->getQueensDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year >= 2014) {
            $holidays->add($this->getKingsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }
        if ($year >= 1946 && $liberationDay = $this->getLiberationDay($year, HolidayType::OFFICIAL)) {
            $holidays->add($liberationDay);
        }
        $holidays->add($this->getWhitSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getQueensDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = ($year < 1949) ? "08-31" : "04-30";
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, "{$year}-{$date}");
        $weekDay = $date->format('w');
        if ('0' === $weekDay) {
            if($year < 1980) {
                $date->add(new \DateInterval('P1D'));
            } else {
                $date->sub(new \DateInterval('P1D'));
            }
        }

        return Holiday::create(HolidayName::QUEENS_DAY, $date->format(Holiday::DISPLAY_DATE_FORMAT), $additionalType | HolidayType::TRADITIONAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED);
    }

    private function getKingsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, "{$year}-04-27");
        $weekDay = $date->format('w');
        if ('0' === $weekDay) {
            $date->sub(new \DateInterval('P1D')); // Move to Saturday
        }

        return Holiday::create(HolidayName::KINGS_DAY, $date->format(Holiday::DISPLAY_DATE_FORMAT), $additionalType | HolidayType::TRADITIONAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED);
    }

    private function getLiberationDay(int $year, int $additionalType = HolidayType::OTHER): ?Holiday
    {
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, "{$year}-05-05");
        $weekDay = $date->format('w');

        if ($year < 1968) {
            if ('0' === $weekDay) {
                $date->add(new \DateInterval('P1D')); // Move to Monday
            }
        }

        if ($year > 1968 && $year < 1990 && $year % 5 !== 0) {
            return null;
        }

        return Holiday::create(HolidayName::DUTCH_LIBERATION_DAY, $date->format(Holiday::DISPLAY_DATE_FORMAT), $additionalType | HolidayType::TRADITIONAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED | HolidayType::NO_SCHOOL);
    }
}
