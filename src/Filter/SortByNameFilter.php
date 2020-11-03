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
 * SortByNameFilter sorts the list by name.
 * As holidays use a technical name by default, it might make sense to translate to a human-readable format before
 * using this filter, e.g. by applying TranslateFilter.
 */
final class SortByNameFilter extends AbstractSortFilter
{
    /**
     * {@inheritdoc}
     */
    protected function getCompareFunction(): callable
    {
        return static function (Holiday $o1, Holiday $o2) {
            return $o1->getName() <=> $o2->getName();
        };
    }
}
