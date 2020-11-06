<?php

namespace Umulmrum\Holiday\Provider;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

trait CompensatoryDaysTrait
{
    /**
     * If $holiday falls on a Saturday or a Sunday, add the follwing Monday as holiday.
     * If $holiday falls on a Sunday and has a preceding, add the following Monday as holiday.
     */
    private function addLaterCompensatoryDay(HolidayList $holidays, Holiday $holiday, int $type = null, int $daysToAdd = null): void
    {
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, $holiday->getSimpleDate());
        $weekDay = $date->format('w');
        if ('6' === $weekDay) {
            $date->add(new \DateInterval('P'.($daysToAdd ?? 2).'D'));
        } elseif ('0' === $weekDay) {
            $date->add(new \DateInterval('P'.($daysToAdd ?? 1).'D'));
        } else {
            return;
        }

        $holidays->add(Holiday::create(
            $holiday->getName().HolidayName::SUFFIX_COMPENSATORY,
            $date->format(Holiday::DISPLAY_DATE_FORMAT),
            ($type ?? $holiday->getType()) | HolidayType::COMPENSATORY
        ));
    }

    /**
     * If $holiday falls on a Saturday, add the preceding Friday as holiday.
     * If $holiday falls on a Sunday, add the following Monday as holiday.
     */
    private function addNearestCompensatoryDay(HolidayList $holidays, Holiday $holiday, int $year): void
    {
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, $holiday->getSimpleDate());
        $weekDay = $date->format('w');
        if ('6' === $weekDay) {
            if ("$year-01-01" === $holiday->getSimpleDate()) {
                // Do not add compensatory date that falls on December 31st as that day does not belong to the requested year.
                return;
            }
            $date->sub(new \DateInterval('P1D'));
        } elseif ('0' === $weekDay) {
            $date->add(new \DateInterval('P1D'));
        } else {
            return;
        }

        $holidays->add(Holiday::create(
            $holiday->getName().HolidayName::SUFFIX_COMPENSATORY,
            $date->format(Holiday::DISPLAY_DATE_FORMAT),
            $holiday->getType() | HolidayType::COMPENSATORY
        ));
    }

    /**
     * If New Year falls on a Saturday in the year after $year, we add December 31st to $year's holidays.
     */
    private function addCompensatoryNewYearForFollowingYear(HolidayList $holidays, int $year): void
    {
        $date = \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, "$year-12-31");
        if ('5' === $date->format('w')) {
            $holidays->add(Holiday::create(HolidayName::NEW_YEAR_COMPENSATORY, "$year-12-31", HolidayType::COMPENSATORY));
        }
    }
}
