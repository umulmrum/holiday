<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Model;


class HolidayList implements \Countable
{
    /**
     * @var Holiday[]
     */
    private $holidayList = [];

    /**
     * @param Holiday[] $holidays
     */
    public function __construct(array $holidays = [])
    {
        foreach ($holidays as $holiday) {
            $this->add($holiday);
        }
    }

    /**
     * Adds a holiday to the list. If there already is a holiday with the same name and date, then the holiday will
     * not be added a second time, but its types will be added to the existing one.
     *
     * @param Holiday $holiday
     */
    public function add(Holiday $holiday): void
    {
        if (-1 !== $index = $this->getIndexByNameAndDate($holiday->getName(), $holiday->getDate())) {
            $this->holidayList[$index] = new Holiday($holiday->getName(), $holiday->getDate(), $holiday->getType() | $this->holidayList[$index]->getType());
        } else {
            $this->holidayList[] = $holiday;
        }
    }

    private function getIndexByNameAndDate($name, \DateTime $dateTime): int
    {
        $timestamp = $dateTime->getTimestamp();
        foreach ($this->holidayList as $index => $holiday) {
            if ($name === $holiday->getName() && $timestamp === $holiday->getTimestamp()) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * @return Holiday[]
     */
    public function getList(): array
    {
        return $this->holidayList;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return \count($this->holidayList);
    }
}
