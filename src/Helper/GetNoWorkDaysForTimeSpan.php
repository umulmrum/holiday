<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Helper;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Filter\IncludeTimespanFilter;
use Umulmrum\Holiday\Filter\IncludeTypeFilter;
use Umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use Umulmrum\Holiday\Filter\SortByDateFilter;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Weekday\Sundays;

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
                new Sundays(HolidayType::DAY_OFF),
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
