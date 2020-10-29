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

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Filter\IncludeTypeFilter;
use umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use umulmrum\Holiday\Filter\SortByDateFilter;
use umulmrum\Holiday\HolidayCalculator;
use umulmrum\Holiday\HolidayCalculatorInterface;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Sundays;

final class GetNoWorkDaysForTimeSpan
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
     * Returns all days in the given time span in which normally employees do not need to work.
     *
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     * @param HolidayProviderInterface[]                                          $noWorkWeekdayProviders
     *
     * @throws \InvalidArgumentException if an invalid value for $holidayProviders was given or $lastDay is before $firstDay
     */
    public function __invoke($holidayProviders, \DateTime $firstDay, \DateTime $lastDay, array $noWorkWeekdayProviders = []): HolidayList
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
        for ($i = $startYear; $i <= $endYear; ++$i) {
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
}
