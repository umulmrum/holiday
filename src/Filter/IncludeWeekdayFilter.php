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

class IncludeWeekdayFilter implements HolidayFilterInterface
{
    /**
     * @var int[]
     */
    private $weekdays;

    /**
     * @param int|int[] $weekdays
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($weekdays)
    {
        if (true === \is_int($weekdays)) {
            $this->weekdays = [
                $weekdays,
            ];
        } elseif (true === \is_array($weekdays)) {
            foreach ($weekdays as $weekday) {
                if (false === \is_int($weekday)) {
                    throw new \InvalidArgumentException('First argument must be either an integer or an array of integers.');
                }
                $this->weekdays = $weekdays;
            }
        } else {
            throw new \InvalidArgumentException('First argument must be either an integer or an array of integers.');
        }
        $this->weekdays = \array_flip($this->weekdays);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        $newList = new HolidayList();
        foreach ($holidayList->getList() as $holiday) {
            if (true === isset($this->weekdays[(int) $holiday->getFormattedDate('w')])) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
