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

    public function __construct(\DateTimeInterface $firstIncludedDay, \DateTimeInterface $lastIncludedDay)
    {
        $this->firstIncludedDay = clone $firstIncludedDay;
        $this->firstIncludedDay->setTime(0, 0, 0);
        $this->lastIncludedDay = clone $lastIncludedDay;
        $this->lastIncludedDay->setTime(0, 0, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        $lastDayPlusOne = clone $this->lastIncludedDay;
        $lastDayPlusOne->add(new \DateInterval('P1D'));

        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            $date = $holiday->getDate();
            if ($date >= $this->firstIncludedDay && $date < $lastDayPlusOne) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
