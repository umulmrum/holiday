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
     */
    public function add(Holiday $holiday): void
    {
        if (-1 !== $index = $this->getIndexByNameAndDate($holiday->getName(), $holiday->getDate())) {
            $this->holidayList[$index] = new Holiday($holiday->getName(), $holiday->getDate(), $holiday->getType() | $this->holidayList[$index]->getType());
        } else {
            $this->holidayList[] = $holiday;
        }
    }

    public function addAll(HolidayList $holidayList): void
    {
        foreach ($holidayList->getList() as $holiday) {
            $this->add($holiday);
        }
    }

//    public function removeByIndex(int $index): void
//    {
//        \array_splice($this->holidayList, $index, 1);
//    }

    private function getIndexByNameAndDate($name, \DateTimeImmutable $dateTime): int
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
    public function count(): int
    {
        return \count($this->holidayList);
    }

    public function isHoliday(\DateTimeInterface $date): bool
    {
        $formatted = $date->format('Y-m-d');

        foreach ($this->holidayList as $holiday) {
            if ($holiday->getFormattedDate('Y-m-d') === $formatted) {
                return true;
            }
        }

        return false;
    }
}
