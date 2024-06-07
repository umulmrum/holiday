<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Compensatory;

use Umulmrum\Holiday\Filter\AbstractFilter;
use Umulmrum\Holiday\Model\Holiday;

use function str_starts_with;

/**
 * @internal
 */
final class IncludeWithinYearFilter extends AbstractFilter
{
    public function __construct(private readonly int $year) {}

    protected function isIncluded(Holiday $holiday): bool
    {
        return str_starts_with($holiday->getSimpleDate(), $this->year . '-');
    }
}
