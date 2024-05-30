<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday;

use InvalidArgumentException;
use Umulmrum\Holiday\Assert\Assert;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Resolver\ClassNameResolver;
use Umulmrum\Holiday\Resolver\IsoResolver;
use Umulmrum\Holiday\Resolver\MiscResolver;
use Umulmrum\Holiday\Resolver\ResolverHandler;
use Umulmrum\Holiday\Resolver\ResolverHandlerInterface;

use function is_array;
use function is_int;

final class HolidayCalculator implements HolidayCalculatorInterface
{
    use Assert;

    private ResolverHandlerInterface $resolverHandler;

    public function __construct(?ResolverHandlerInterface $resolverHandler = null)
    {
        $this->resolverHandler = $resolverHandler ?? new ResolverHandler([new ClassNameResolver(), new IsoResolver(), new MiscResolver()]);
    }

    public function calculate($holidayProviders, $years): HolidayList
    {
        $finalYears = $this->interpretYears($years);

        $holidays = new HolidayList();
        foreach ($this->resolverHandler->resolve($holidayProviders) as $holidayProvider) {
            foreach ($finalYears as $year) {
                $holidays->addAll($holidayProvider->calculateHolidaysForYear($year));
            }
        }

        return $holidays;
    }

    /**
     * @param int|int[] $years
     *
     * @return int[]
     *
     * * @throws InvalidArgumentException
     */
    private function interpretYears($years): array
    {
        if (is_int($years)) {
            return [$years];
        }

        if (is_array($years)) {
            $this->assertIntArray($years);

            return $years;
        }

        throw new InvalidArgumentException('Year needs to be either int or an array of int');
    }
}
