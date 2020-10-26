<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

final class IncludeUniqueDateFilter extends AbstractFilter
{
    private $foundTimestamps = [];

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): void
    {
        parent::filter($holidayList);
        $this->foundTimestamps = [];
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        $found = isset($this->foundTimestamps[$holiday->getTimestamp()]);
        if (false === $found) {
            $this->foundTimestamps[$holiday->getTimestamp()] = true;
        }

        return false === $found;
    }
}
