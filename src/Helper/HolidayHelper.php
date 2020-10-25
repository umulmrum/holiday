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
final class HolidayHelper
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculator;

    public function __construct(HolidayCalculatorInterface $holidayCalculator = null)
    {
        $this->holidayCalculator = $holidayCalculator ?? new HolidayCalculator();
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
        $holidayList = $this->holidayCalculator->calculate($holidayProviders, $year);
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
     * @param int|int[]                                                           $years
     * @param string                                                              $holidayName most likely on of the constants in \umulmrum\Holiday\Constant\HolidayName
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders or $years was given
     */
    public function getHolidaysByName($holidayProviders, $years, string $holidayName): HolidayList
    {
        return $this->holidayCalculator->calculate($holidayProviders, $years)->filter(new IncludeHolidayNameFilter($holidayName));
    }

    /**
     * Returns all days in the given time span in which normally employees do not need to work.
     * Be aware that this method is quite heavy-weight if multiple no-work days for multiple years are requested.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param HolidayProviderInterface[]                                          $noWorkWeekdayProviders
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given or $lastDay is before $firstDay
     */
    public function getNoWorkDaysForTimeSpan($holidayProviders, \DateTime $firstDay, \DateTime $lastDay, array $noWorkWeekdayProviders = []): HolidayList
    {
        if ($lastDay < $firstDay) {
            throw new \InvalidArgumentException('lastDay must not be before firstDay');
        }

        if (\count($noWorkWeekdayProviders) > 0) {
            $noWork = $noWorkWeekdayProviders;
        } else {
            $noWork = [
                Sundays::class,
            ];
        }
        if (false === \is_array($holidayProviders)) {
            $holidayProviders = [$holidayProviders];
        }
        $holidayProviders = \array_merge($holidayProviders, $noWork);

        $startYear = (int) $firstDay->format('Y');
        $endYear = (int) $lastDay->format('Y');

        $years = [];
        for ($i = $startYear; $i <= $endYear; $i++) {
            $years[] = $i;
        }

        return $this->holidayCalculator
            ->calculate($holidayProviders, $years)
            ->filter(new IncludeTimespanFilter($firstDay, $lastDay))
            ->filter(new IncludeTypeFilter(HolidayType::DAY_OFF))
            ->filter(new IncludeUniqueDateFilter())
            ->filter(new SortByDateFilter())
        ;
    }

    public function getHolidayListInICalendarFormat(HolidayList $holidayList, TranslatorInterface $translator = null, DateProviderInterface $dateHelper = null): string
    {
        $calendarFormatter = new ICalendarFormatter($translator, $dateHelper);
        $content = [];
        $content[] = $calendarFormatter->getHeader();
        $content = array_merge($content, $calendarFormatter->formatList($holidayList));
        $content[] = $calendarFormatter->getFooter();

        return \implode(ICalendarFormatter::LINE_ENDING, $content).ICalendarFormatter::LINE_ENDING;
    }
}
