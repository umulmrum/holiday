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

use InvalidArgumentException;
use Umulmrum\Holiday\Filter\IncludeTimespanFilter;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\DateCreatorTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final readonly class GetHolidaysForMonth
{
    use DateCreatorTrait;

    public function __construct(private HolidayCalculatorInterface $holidayCalculator = new HolidayCalculator()) {}

    /**
     * Returns all holidays for the given month.
     *
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $holidayProviders
     *
     * @throws InvalidArgumentException if an invalid value for $holidayProviders was given
     */
    public function __invoke($holidayProviders, int $year, int $month): HolidayList
    {
        $holidayList = $this->holidayCalculator->calculate($holidayProviders, $year);
        $startDate = $this->createDisplayDateFromString("{$year}-{$month}-01");
        $lastDayOfMonth = (int) $startDate->format('t');
        $endDate = $this->createDisplayDateFromString("{$year}-{$month}-{$lastDayOfMonth}");

        return $holidayList->filter(new IncludeTimespanFilter($startDate, $endDate));
    }
}
