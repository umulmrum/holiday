<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Helper;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Filter\IncludeHolidayNameFilter;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Filter\IncludeTypeFilter;
use umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use umulmrum\Holiday\Filter\SortByDateFilter;
use umulmrum\Holiday\Formatter\ICalendarFormatter;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Provider\Weekday\Weekdays;
use umulmrum\Holiday\Translator\TranslatorInterface;

/**
 * HolidayHelper provides helper methods that ease holiday calculations for common use cases.
 */
class HolidayHelper
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculator;

    public function __construct(HolidayCalculatorInterface $holidayCalculator)
    {
        $this->holidayCalculator = $holidayCalculator;
    }

    /**
     * Returns if the given date is a holiday in the given region.
     *
     * @param \DateTime $dateTime
     *
     * @return bool true if the day is a holiday, else false
     */
    public function isDayAHoliday(\DateTime $dateTime): bool
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear((int) $dateTime->format('Y'), $dateTime->getTimezone());
        $filteredHolidays = (new IncludeTimespanFilter())->filter($holidayList, [
            IncludeTimespanFilter::PARAM_FIRST_DAY => $dateTime,
            IncludeTimespanFilter::PARAM_LAST_DAY => $dateTime,
        ]);

        return \count($filteredHolidays) > 0;
    }

    /**
     * Returns all holidays for the given month in the given region.
     *
     * @param int           $year
     * @param int           $month
     * @param \DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysForMonth(int $year, int $month, \DateTimeZone $timezone = null): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $timezone);
        $date = new \DateTime(sprintf('%s-%s-01', $year, $month), $timezone);
        $lastDayOfMonth = (int) $date->format('t');
        $filteredHolidays = (new IncludeTimespanFilter())->filter($holidayList, [
            IncludeTimespanFilter::PARAM_FIRST_DAY => $date,
            IncludeTimespanFilter::PARAM_LAST_DAY => new \DateTime(sprintf('%s-%s-%s', $year, $month, $lastDayOfMonth), $timezone),
        ]);

        return $filteredHolidays;
    }

    /**
     * Returns all holidays with the given name for the given year in the given region. Note that holiday names are
     * not necessarily unique, and therefore a HolidayList object is returned.
     *
     * @param int          $year
     * @param string       $holidayName Most likely on of the constants in \umulmrum\Holiday\Constant\HolidayName.
     * @param \DateTimeZone $timezone
     *
     * @return HolidayList
     */
    public function getHolidaysByName(int $year, string $holidayName, \DateTimeZone $timezone = null): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $timezone);
        $filteredHolidays = (new IncludeHolidayNameFilter())->filter($holidayList, [
            IncludeHolidayNameFilter::PARAM_HOLIDAY_NAME => $holidayName,
        ]);

        return $filteredHolidays;
    }

    /**
     * Returns all days in the given timespan and the region in which normally employees do not need to work.
     * Be aware that this method is quite heavy-weight if multiple no-work days for multiple years are requested.
     *
     * @param \DateTime                   $firstDay
     * @param \DateTime                   $lastDay
     * @param HolidayProviderInterface[]  $noWorkWeekdayProviders
     *
     * @return HolidayList
     */
    public function getNoWorkDaysForTimespan(\DateTime $firstDay, \DateTime $lastDay, array $noWorkWeekdayProviders = []): HolidayList
    {
        if (\count($noWorkWeekdayProviders) > 0) {
            $noWork = $noWorkWeekdayProviders;
        } else {
            $noWork = [
                Sundays::class,
            ];
        }

        $startYear = (int) $firstDay->format('Y');
        $endYear = (int) $lastDay->format('Y');

        if ($startYear === $endYear) {
            $holidayList = $this->getNoWorkDaysWithinSingleYear($firstDay, $lastDay, $startYear, $noWork);
        } else {
            $holidayList = $this->getNoWorkDaysOverMultipleYears($firstDay, $lastDay, $startYear, $endYear, $noWork);
        }

        return (new SortByDateFilter())->filter($holidayList);
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $lastDay
     * @param int $year
     * @param Weekdays[] $noWork
     *
     * @return HolidayList
     */
    private function getNoWorkDaysWithinSingleYear(\DateTime $firstDay, \DateTime $lastDay, int $year, array $noWork): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($year, $firstDay->getTimezone());
        $holidayList = (new IncludeTypeFilter())->filter($holidayList, [
            IncludeTypeFilter::PARAM_HOLIDAY_TYPE => HolidayType::DAY_OFF,
        ]);
        $temporaryHolidayCalculator = new HolidayCalculator($noWork);
        $holidayList->addAll($temporaryHolidayCalculator->calculateHolidaysForYear($year, $firstDay->getTimezone()));

        $holidayList = (
        new IncludeTimespanFilter(new IncludeUniqueDateFilter()))
            ->filter($holidayList, [
                IncludeTimespanFilter::PARAM_FIRST_DAY => $firstDay,
                IncludeTimespanFilter::PARAM_LAST_DAY => $lastDay,
            ]);

        return $holidayList;
    }

    /**
     * @param \DateTime $firstDay
     * @param \DateTime $lastDay
     * @param int $startYear
     * @param int $endYear
     * @param Weekdays[] $noWork
     *
     * @return HolidayList
     */
    private function getNoWorkDaysOverMultipleYears(\DateTime $firstDay, \DateTime $lastDay, int $startYear, int $endYear, array $noWork): HolidayList
    {
        $holidayList = $this->getNoWorkDaysForTimespan($firstDay, new \DateTime(sprintf('%s-12-31', $startYear), $firstDay->getTimezone()), $noWork);
        for ($year = $startYear + 1; $year < $endYear; ++$year) {
            $holidayList->addAll($this->getNoWorkDaysForTimespan(
                new \DateTime(sprintf('%s-01-01', $year), $firstDay->getTimezone()),
                new \DateTime(sprintf('%s-12-31', $year), $firstDay->getTimezone()),
                $noWork)
            );
        }
        $holidayList->addAll($this->getNoWorkDaysForTimespan(new \DateTime(sprintf('%s-01-01', $endYear), $firstDay->getTimezone()), $lastDay, $noWork));

        return $holidayList;
    }

    /**
     * @param HolidayList              $holidayList
     * @param TranslatorInterface|null $translator
     * @param DateHelper               $dateHelper
     *
     * @return string
     */
    public function getHolidayListInICalendarFormat(HolidayList $holidayList, TranslatorInterface $translator = null, DateHelper $dateHelper = null): string
    {
        $calendarFormatter = new ICalendarFormatter($translator, $dateHelper);
        $content = [];
        $content[] = $calendarFormatter->getHeader();
        $content = array_merge($content, $calendarFormatter->formatList($holidayList));
        $content[] = $calendarFormatter->getFooter();

        return implode(ICalendarFormatter::LINE_ENDING, $content).ICalendarFormatter::LINE_ENDING;
    }
}
