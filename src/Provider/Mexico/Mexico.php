<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Mexico;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\CompensatoryDaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Mexico implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use CompensatoryDaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $this->addNewYear($holidays, $year);
        $this->addConstitutionDay($holidays, $year);
        $this->addBirthdayOfBenitoJuarez($holidays, $year);
        if ($year >= 1923) {
            $this->addLaborDay($holidays, $year);
        }
        if ($year >= 1826) {
            $this->addIndependenceDay($holidays, $year);
        }
        $this->addRevolutionDay($holidays, $year);
        $this->addChristmasDay($holidays, $year);

        return $holidays;
    }

    private function addNewYear(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addConstitutionDay(HolidayList $holidays, int $year): void
    {
        if ($year >= 2006) {
            $date = (new \DateTime("First Monday of {$year}-02"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } elseif ($year >= 1918) {
            $date = "{$year}-02-05";
        } else {
            return;
        }
        $holiday = Holiday::create(HolidayName::CONSTITUTION_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addBirthdayOfBenitoJuarez(HolidayList $holidays, int $year): void
    {
        if ($year >= 2006) {
            $date = (new \DateTime("Third Monday of {$year}-03"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } else {
            $date = "{$year}-02-05";
        }
        $holiday = Holiday::create(HolidayName::BIRTHDAY_OF_BENITO_JUAREZ, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addLaborDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addIndependenceDay(HolidayList $holidays, int $year): void
    {
        $holiday = Holiday::create(HolidayName::INDEPENDENCE_DAY, "{$year}-09-16", HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addRevolutionDay(HolidayList $holidays, int $year): void
    {
        if ($year >= 2006) {
            $date = (new \DateTime("Third Monday of {$year}-11"))->format(Holiday::DISPLAY_DATE_FORMAT);
        } elseif ($year >= 1911) {
            $date = "{$year}-11-20";
        } else {
            return;
        }
        $holiday = Holiday::create(HolidayName::REVOLUTION_DAY, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }

    private function addChristmasDay(HolidayList $holidays, int $year): void
    {
        $holiday = $this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF);
        $holidays->add($holiday);
        $this->addNearestCompensatoryDay($holidays, $holiday, $year);
    }
}
