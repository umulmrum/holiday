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

use umulmrum\Holiday\Model\HolidayList;

class IncludeTimespanFilter implements HolidayFilterInterface
{

    /**
     * @var \DateTime
     */
    private $firstIncludedDay;
    /**
     * @var \DateTime
     */
    private $lastIncludedDay;

    public function __construct(\DateTime $firstIncludedDay, \DateTime $lastIncludedDay)
    {
        $this->firstIncludedDay = $firstIncludedDay;
        $this->lastIncludedDay = $lastIncludedDay;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        // TODO set time to 00:00:00 for both dates
        $firstDayTimestamp = $this->firstIncludedDay->getTimestamp();
        $lastDayPlusOne = clone $this->lastIncludedDay;
        $lastDayPlusOne->add(new \DateInterval('P1D'));
        $lastDayPlusOneTimestamp = $lastDayPlusOne->getTimestamp();

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            $timestamp = $holiday->getTimestamp();
            if ($timestamp >= $firstDayTimestamp && $timestamp < $lastDayPlusOneTimestamp) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
