<?php

namespace umulmrum\Holiday\Helper;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Exception\HolidayException;
use umulmrum\Holiday\Filter\IncludeHolidayNameFilter;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use umulmrum\Holiday\Filter\SortByDateFilter;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Weekday\Sundays;

/**
 * HolidayHelper provides helper methods that ease holiday calculations for common use cases.
 */
class HolidayHelper
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculator;

    /**
     * @param HolidayCalculatorInterface $holidayCalculator
     */
    public function __construct(HolidayCalculatorInterface $holidayCalculator)
    {
        $this->holidayCalculator = $holidayCalculator;
    }

    /**
     * Returns if the given date is a holiday in the given region.
     * @param DateTime                 $dateTime
     * @param string                   $region
     *
     * @return bool true if the day is a holiday, else false
     *
     * @throws HolidayException
     */
    public function isDayAHoliday(DateTime $dateTime, $region)
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear((int) $dateTime->format('Y'), $region, $dateTime->getTimezone());
        $filteredHolidays = (new IncludeTimespanFilter())->filter($holidayList, [
            IncludeTimespanFilter::PARAM_FIRST_DAY => $dateTime,
            IncludeTimespanFilter::PARAM_LAST_DAY => $dateTime,
        ]);

        return count($filteredHolidays) > 0;
    }

    /**
     * Returns all holidays for the given month in the given region.
     * @param int $year
     * @param int $month
     * @param string $region
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysForMonth($year, $month, $region, DateTimeZone $timezone = null)
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $region, $timezone);
        $date = new DateTime(sprintf('%s-%s-01', $year, $month), $timezone);
        $lastDayOfMonth = (int) $date->format('t');
        $filteredHolidays = (new IncludeTimespanFilter())->filter($holidayList, [
            IncludeTimespanFilter::PARAM_FIRST_DAY => $date,
            IncludeTimespanFilter::PARAM_LAST_DAY => new DateTime(sprintf('%s-%s-%s', $year, $month, $lastDayOfMonth), $timezone),
        ]);

        return $filteredHolidays;
    }

    /**
     * Returns all holidays with the given name for the given year in the given region. Note that holiday names are
     * not necessarily unique, and therefore a HolidayList object is returned.
     * @param int $year
     * @param string $holidayName
     * @param string $region
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysByName($year, $holidayName, $region, DateTimeZone $timezone = null)
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $region, $timezone);
        $filteredHolidays = (new IncludeHolidayNameFilter())->filter($holidayList, [
            IncludeHolidayNameFilter::PARAM_HOLIDAY_NAME => $holidayName,
        ]);

        return $filteredHolidays;
    }

    /**
     * Returns all days in the given timespan and the region in which normally employees do not need to work.
     * @param DateTime $firstDay
     * @param DateTime $lastDay
     * @param string $region
     * @param array $noWorkWeekdays
     *
     * @return HolidayList
     */
    public function getNoWorkDaysForTimespan(DateTime $firstDay, DateTime $lastDay, $region, array $noWorkWeekdays = [])
    {

        $noWork = [];
        if (count($noWorkWeekdays) > 0) {
            $noWork = $noWorkWeekdays;
        } else {
            $noWork = [
                Weekday::SUNDAY,
            ];
        }


        $startYear = (int) $firstDay->format('Y');
        $endYear = (int) $lastDay->format('Y');


        if ($startYear === $endYear) {
            $holidays = [];
            $holidays[] = $this->holidayCalculator->calculateHolidaysForYear($startYear, $region, $firstDay->getTimezone());
            $holidays[] = $this->holidayCalculator->calculateHolidaysForYear($startYear, Sundays::ID, $firstDay->getTimezone());

            $holidayList = $this->mergeHolidayLists($holidays);
            $holidayList = (
                new IncludeTimespanFilter(
                new IncludeUniqueDateFilter(
                )))->filter($holidayList, [
                IncludeTimespanFilter::PARAM_FIRST_DAY => $firstDay,
                IncludeTimespanFilter::PARAM_LAST_DAY => $lastDay,
            ]);
        } else {
            $holidays = [];
            $holidays[] = $this->getNoWorkDaysForTimespan($firstDay, new DateTime(sprintf('%s-12-31', $startYear), $firstDay->getTimezone()), $region, $noWork);
            for ($year = $startYear + 1; $year < $endYear; $year++) {
                $holidays[] = $this->getNoWorkDaysForTimespan(
                    new DateTime(sprintf('%s-01-01', $year), $firstDay->getTimezone()),
                    new DateTime(sprintf('%s-12-31', $year), $firstDay->getTimezone()),
                    $region,
                    $noWork);
            }
            $holidays[] = $this->getNoWorkDaysForTimespan(new DateTime(sprintf('%s-01-01', $endYear), $firstDay->getTimezone()), $lastDay, $region, $noWork);
            $holidayList = $this->mergeHolidayLists($holidays);
        }

        return $holidayList;
    }

    /**
     * Returns a merged list of all the HolidayList objects given.
     * @param HolidayList[] $holidayLists
     *
     * @return HolidayList
     */
    public function mergeHolidayLists(array $holidayLists)
    {
        $newList = new HolidayList();
        foreach ($holidayLists as $holidayList) {
            foreach ($holidayList->getFlatArray() as $holiday) {
                $newList->add($holiday);
            }
        }

        return (new SortByDateFilter())->filter($newList);
    }
}
