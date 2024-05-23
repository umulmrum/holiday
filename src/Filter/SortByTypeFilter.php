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

use Umulmrum\Holiday\Model\Holiday;

/**
 * SortByTypeFilter sorts the list by type.
 */
final class SortByTypeFilter extends AbstractSortFilter
{
    protected function getCompareFunction(): callable
    {
        return static fn (Holiday $o1, Holiday $o2) => $o1->getType() <=> $o2->getType();
    }
}
