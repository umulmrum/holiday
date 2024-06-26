<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use DateTimeInterface;
use Umulmrum\Holiday\Model\Holiday;

/**
 * IncludeTimespanFilter retains all holidays that lie within the timespan passed as constructor arguments (including
 * these days).
 */
final class IncludeTimespanFilter extends AbstractFilter
{
    private readonly string $firstIncludedDay;

    private readonly string $lastIncludedDay;

    public function __construct(DateTimeInterface $firstIncludedDay, DateTimeInterface $lastIncludedDay)
    {
        $this->firstIncludedDay = $firstIncludedDay->format(Holiday::DISPLAY_DATE_FORMAT);
        $this->lastIncludedDay = $lastIncludedDay->format(Holiday::DISPLAY_DATE_FORMAT);
    }

    protected function isIncluded(Holiday $holiday): bool
    {
        $date = $holiday->getSimpleDate();

        return $date >= $this->firstIncludedDay && $date <= $this->lastIncludedDay;
    }
}
