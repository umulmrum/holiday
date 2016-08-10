<?php

namespace umulmrum\Holiday\Helper;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Exception\HolidayException;
use umulmrum\Holiday\Filter\IncludeHolidayNameFilter;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Filter\IncludeTypeFilter;
use umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use umulmrum\Holiday\Filter\IncludeWeekdayFilter;
use umulmrum\Holiday\Filter\SortByDateFilter;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Weekdays;

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
     * @param DateTime                 $dateTime
     * @param HolidayProviderInterface $region
     *
     * @return bool
     *
     * @throws HolidayException
     */
    public function isDayAHoliday(DateTime $dateTime, HolidayProviderInterface $region)
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear((int) $dateTime->format('Y'), $region, $dateTime->getTimezone());
        $filteredHolidays = (new IncludeTimespanFilter())->filter($holidayList, [
            IncludeTimespanFilter::PARAM_FIRST_DAY => $dateTime,
            IncludeTimespanFilter::PARAM_LAST_DAY => $dateTime,
        ]);

        return count($filteredHolidays) > 0;
    }

    /**
     * @param int $year
     * @param int $month
     * @param HolidayProviderInterface $region
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysForMonth($year, $month, HolidayProviderInterface $region, DateTimeZone $timezone = null)
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
     * @param int $year
     * @param string $holidayName
     * @param HolidayProviderInterface $region
     * @param DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysByName($year, $holidayName, HolidayProviderInterface $region, DateTimeZone $timezone = null)
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $region, $timezone);
        $filteredHolidays = (new IncludeHolidayNameFilter())->filter($holidayList, [
            IncludeHolidayNameFilter::PARAM_HOLIDAY_NAME => $holidayName,
        ]);

        return $filteredHolidays;
    }

    /**
     * @param DateTime $firstDay
     * @param DateTime $lastDay
     * @param HolidayProviderInterface $region
     *
     * @return HolidayList
     */
    public function getNoWorkDaysForTimespan(DateTime $firstDay, DateTime $lastDay, HolidayProviderInterface $region, array $noWorkWeekdays = [])
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
            $holidays[] = $this->holidayCalculator->calculateHolidaysForYear($startYear, new Weekdays(Weekday::SUNDAY), $firstDay->getTimezone());

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
