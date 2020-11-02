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
use Umulmrum\Holiday\Model\HolidayList;

/**
 * IncludeUniqueDateFilter rejects all holidays with a duplicate date in the filtered HolidayList. The first holiday with
 * any date is retained, but note that order is not defined in the result of HolidayCalculator. Depending on the use case,
 * it might make sense to apply other filters before, e.g. to sort or remove holidays, to receive more reliable results.
 */
final class IncludeUniqueDateFilter extends AbstractFilter
{
    /** @var bool[] */
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
        $found = isset($this->foundTimestamps[$holiday->getSimpleDate()]);
        if (false === $found) {
            $this->foundTimestamps[$holiday->getSimpleDate()] = true;
        }

        return false === $found;
    }
}
