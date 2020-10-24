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
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Sundays;
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
     * Returns all holidays for the given month.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function getHolidaysForMonth($holidayProviders, int $year, int $month): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($holidayProviders, $year);
        $startDate = \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-%s-01', $year, $month));
        $lastDayOfMonth = (int) $startDate->format('t');
        $endDate = \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-%s-%s', $year, $month, $lastDayOfMonth));

        return (new IncludeTimespanFilter($startDate, $endDate))->filter($holidayList);
    }

    /**
     * Returns all holidays with the given name for the given year. Note that holiday names are
     * not necessarily unique, and therefore a HolidayList object is returned.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param string                                                              $holidayName      most likely on of the constants in \umulmrum\Holiday\Constant\HolidayName
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function getHolidaysByName($holidayProviders, int $year, string $holidayName): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($holidayProviders, $year);

        return (new IncludeHolidayNameFilter($holidayName))->filter($holidayList);
    }

    /**
     * Returns all days in the given time span in which normally employees do not need to work.
     * Be aware that this method is quite heavy-weight if multiple no-work days for multiple years are requested.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param HolidayProviderInterface[]                                          $noWorkWeekdayProviders
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function getNoWorkDaysForTimeSpan($holidayProviders, \DateTime $firstDay, \DateTime $lastDay, array $noWorkWeekdayProviders = []): HolidayList
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
            $holidayList = $this->getNoWorkDaysWithinSingleYear($holidayProviders, $firstDay, $lastDay, $startYear, $noWork);
        } else {
            $holidayList = $this->getNoWorkDaysOverMultipleYears($holidayProviders, $firstDay, $lastDay, $startYear, $endYear, $noWork);
        }

        return (new SortByDateFilter())->filter($holidayList);
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[]$holidayProviders
     * @param HolidayProviderInterface[] $noWork
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    private function getNoWorkDaysWithinSingleYear($holidayProviders, \DateTime $firstDay, \DateTime $lastDay, int $year, array $noWork): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculateHolidaysForYear($holidayProviders, $year);
        $holidayList = (new IncludeTypeFilter(HolidayType::DAY_OFF))->filter($holidayList);
        $temporaryHolidayCalculator = new HolidayCalculator();
        $holidayList->addAll($temporaryHolidayCalculator->calculateHolidaysForYear($noWork, $year));

        $holidayList = (new IncludeUniqueDateFilter())->filter($holidayList);
        $holidayList = (new IncludeTimespanFilter($firstDay, $lastDay))->filter($holidayList);

        return $holidayList;
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param HolidayProviderInterface[]                                          $noWork
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    private function getNoWorkDaysOverMultipleYears($holidayProviders, \DateTime $firstDay, \DateTime $lastDay, int $startYear, int $endYear, array $noWork): HolidayList
    {
        $holidayList = $this->getNoWorkDaysForTimeSpan(
            $holidayProviders,
            $firstDay,
            \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-12-31', $startYear)), $noWork
        );
        for ($year = $startYear + 1; $year < $endYear; ++$year) {
            $holidayList->addAll(
                $this->getNoWorkDaysForTimeSpan(
                $holidayProviders,
                \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-01-01', $year)),
                \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-12-31', $year)),
                $noWork
            )
            );
        }
        $holidayList->addAll($this->getNoWorkDaysForTimeSpan(
            $holidayProviders,
            \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-01-01', $endYear)),
            $lastDay,
            $noWork)
        );

        return $holidayList;
    }

    public function getHolidayListInICalendarFormat(HolidayList $holidayList, TranslatorInterface $translator = null, DateHelper $dateHelper = null): string
    {
        $calendarFormatter = new ICalendarFormatter($translator, $dateHelper);
        $content = [];
        $content[] = $calendarFormatter->getHeader();
        $content = array_merge($content, $calendarFormatter->formatList($holidayList));
        $content[] = $calendarFormatter->getFooter();

        return \implode(ICalendarFormatter::LINE_ENDING, $content).ICalendarFormatter::LINE_ENDING;
    }
}
