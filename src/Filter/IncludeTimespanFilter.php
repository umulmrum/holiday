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

final class IncludeTimespanFilter extends AbstractFilter
{
    /**
     * @var \DateTime
     */
    private $firstIncludedDay;
    /**
     * @var \DateTime
     */
    private $lastIncludedDay;

    public function __construct(\DateTimeInterface $firstIncludedDay, \DateTimeInterface $lastIncludedDay)
    {
        $this->firstIncludedDay = $firstIncludedDay->format(Holiday::DISPLAY_DATE_FORMAT);
        $this->lastIncludedDay = $lastIncludedDay->format(Holiday::DISPLAY_DATE_FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        $date = $holiday->getSimpleDate();

        return $date >= $this->firstIncludedDay && $date <= $this->lastIncludedDay;
    }
}
