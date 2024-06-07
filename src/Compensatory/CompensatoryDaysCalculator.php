<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Compensatory;

use DateInterval;
use DateTimeImmutable;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\DateCreatorTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final readonly class CompensatoryDaysCalculator implements CompensatoryDaysCalculatorInterface
{
    use DateCreatorTrait;

    /**
     * @param string[] $forTheseHolidayNamesOnly If empty, calculate compensatory days for all holidays where required;
     *                                           else calculate only for holidays with names in the list
     * @param int[]    $weekDaysToStepBackward   Week days in this list will be treated as weekend and therefore skipped;
     *                                           compensatory days will be searched backward in time, e.g. usually on
     *                                           Friday if Saturday is in the list. Use Weekday::* constants as values.
     * @param int[]    $weekDaysToStepForward    Week days in this list will be treated as weekend and therefore skipped;
     *                                           compensatory days will be searched forward in time, e.g. usually on
     *                                           Monday if Sunday is in the list. Use Weekday::* constants as values.
     */
    public function __construct(
        private array $forTheseHolidayNamesOnly = [],
        private array $weekDaysToStepBackward = [],
        private array $weekDaysToStepForward = [Weekday::SATURDAY, Weekday::SUNDAY],
    ) {}

    public function addAll(HolidayList $holidays, HolidayProviderInterface $holidayProvider, int $year): void
    {
        $this->doAddAll($holidays, $year, false);
        $this->addCompensatoryDayForLastDayOfPreviousYear($holidays, $holidayProvider, $year);
        $this->addCompensatoryDayForFirstDayOfFollowingYear($holidays, $holidayProvider, $year);
    }

    private function doAddAll(HolidayList $holidays, int $year, bool $ignoreYearBoundary): void
    {
        if ($this->forTheseHolidayNamesOnly === []) {
            foreach ($holidays as $holiday) {
                $this->addCompensatoryDay($holidays, $holiday, $year, $ignoreYearBoundary);
            }
        } else {
            foreach ($this->forTheseHolidayNamesOnly as $holidayName) {
                foreach ($holidays->getByName($holidayName) as $holiday) {
                    $this->addCompensatoryDay($holidays, $holiday, $year, $ignoreYearBoundary);
                }
            }
        }
    }

    private function addCompensatoryDay(HolidayList $holidays, Holiday $holiday, int $year, bool $ignoreYearBoundary): void
    {
        $newDate = $this->calculateNewDate($holidays, $holiday, $year, $ignoreYearBoundary);
        if ($newDate === null) {
            return;
        }

        $holidays->add(Holiday::create(
            $holiday->getName() . HolidayName::SUFFIX_COMPENSATORY,
            $newDate->format(Holiday::DISPLAY_DATE_FORMAT),
            $holiday->getType() | HolidayType::COMPENSATORY,
        ));
    }

    private function calculateNewDate(HolidayList $holidays, Holiday $holiday, int $year, bool $ignoreYearBoundary = false, ?int $forceDirection = null): ?DateTimeImmutable
    {
        $originalDate = $holiday->getDate();
        $weekDay = (int) $originalDate->format('w');
        $direction = $forceDirection ?? $this->getDirection($weekDay);
        if ($direction === 0) {
            return null;
        }
        $interval = new DateInterval('P1D');
        if ($direction === -1) {
            $interval->invert = 1;
        }
        $tries = 10;
        $newDate = $originalDate;
        do {
            $newDate = $newDate->add($interval);
            $weekDay = (int) $newDate->format('w');
            --$tries;
        } while ($tries > 0
            && (
                in_array($weekDay, $this->weekDaysToStepBackward, true)
                || in_array($weekDay, $this->weekDaysToStepForward, true)
                || $holidays->isHoliday($newDate)
            ));

        if ($tries === 0 && $holidays->isHoliday($newDate)) {
            return null;
        }
        if (!$ignoreYearBoundary && $newDate->format('Y') !== (string) $year) {
            return null;
        }

        return $newDate;
    }

    /**
     * Determines if compensatory days should be located before or after the original holiday.
     * Returns a positive value to try a day in the future of the last tried day, and a negative value to try a day in
     * the past of the last tried day.
     * Returns zero to indicate that no compensatory holiday is needed for the given $weekDay.
     */
    private function getDirection(int $weekDay): int
    {
        if (in_array($weekDay, $this->weekDaysToStepBackward, true)) {
            return -1;
        }
        if (in_array($weekDay, $this->weekDaysToStepForward, true)) {
            return 1;
        }

        return 0;
    }

    private function addCompensatoryDayForLastDayOfPreviousYear(HolidayList $holidays, HolidayProviderInterface $holidayProvider, int $year): void
    {
        $previousYear = $year - 1;
        $weekDayOfLastDayOfPreviousYear = (int) $this->createDateFromString("{$previousYear}-12-31")->format('w');
        if (!in_array($weekDayOfLastDayOfPreviousYear, $this->weekDaysToStepForward, true)) {
            return;
        }

        $this->addCompensatoryDaysForOtherYear($holidayProvider, $previousYear, $year, $holidays, 1);
    }

    private function addCompensatoryDayForFirstDayOfFollowingYear(HolidayList $holidays, HolidayProviderInterface $holidayProvider, int $year): void
    {
        $followingYear = $year + 1;
        $weekDayOfFirstDayOfFollowingYear = (int) $this->createDateFromString("{$followingYear}-01-01")->format('w');
        if (!in_array($weekDayOfFirstDayOfFollowingYear, $this->weekDaysToStepBackward, true)) {
            return;
        }

        $this->addCompensatoryDaysForOtherYear($holidayProvider, $followingYear, $year, $holidays, -1);
    }

    private function addCompensatoryDaysForOtherYear(HolidayProviderInterface $holidayProvider, int $otherYear, int $currentYear, HolidayList $holidays, int $direction): void
    {
        /*
         * Calculate holidays and compensatory days for the other year; ignore year boundary to get compensatory holidays
         * that lie in the current year
         */
        $holidaysOtherYear = $holidayProvider->calculateHolidaysForYear($otherYear);
        $this->doAddAll($holidaysOtherYear, $otherYear, true);
        // Keep only (compensatory) days in the current year
        $holidaysOtherYear->filter(new IncludeWithinYearFilter($currentYear));
        /*
         * Add all of these days to the holidays of the current year. As the first day of the year might also be a holiday,
         * check if the day needs to be moved even further
         */
        foreach ($holidaysOtherYear as $newHolidayInCurrentYear) {
            $newDate = null;
            if ($holidays->isHoliday($newHolidayInCurrentYear->getDate())) {
                $newDate = $this->calculateNewDate($holidays, $newHolidayInCurrentYear, $currentYear, forceDirection: $direction);
            }
            if ($newDate === null) {
                $holidays->add($newHolidayInCurrentYear);
            } else {
                $holidays->add(Holiday::create(
                    $newHolidayInCurrentYear->getName(),
                    $newDate->format(Holiday::DISPLAY_DATE_FORMAT),
                    $newHolidayInCurrentYear->getType(),
                ));
            }
        }
    }
}
