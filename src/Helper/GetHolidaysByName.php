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
use Umulmrum\Holiday\Filter\IncludeHolidayNameFilter;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final readonly class GetHolidaysByName
{
    public function __construct(private HolidayCalculatorInterface $holidayCalculator = new HolidayCalculator()) {}

    /**
     * Returns all holidays with the given name for the given years. Note that holiday names are
     * not necessarily unique, which is why a HolidayList object is returned.
     *
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $holidayProviders
     * @param int|int[]                                                           $years
     * @param string                                                              $holidayName      most likely on of the constants in \Umulmrum\Holiday\Constant\HolidayName
     *
     * @throws InvalidArgumentException if an invalid value for $holidayProviders or $years was given
     */
    public function __invoke($holidayProviders, $years, string $holidayName): HolidayList
    {
        return $this->holidayCalculator->calculate($holidayProviders, $years)->filter(new IncludeHolidayNameFilter($holidayName));
    }
}
