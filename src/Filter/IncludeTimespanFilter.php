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
    private $lastIncludedDayPlusOne;

    public function __construct(\DateTimeInterface $firstIncludedDay, \DateTimeInterface $lastIncludedDay)
    {
        $this->firstIncludedDay = clone $firstIncludedDay;
        $this->firstIncludedDay->setTime(0, 0, 0);
        $this->lastIncludedDayPlusOne = clone $lastIncludedDay;
        $this->lastIncludedDayPlusOne->add(new \DateInterval('P1D'));
        $this->lastIncludedDayPlusOne->setTime(0, 0, 0);
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        $date = $holiday->getDate();

        return $date >= $this->firstIncludedDay && $date < $this->lastIncludedDayPlusOne;
    }
}
