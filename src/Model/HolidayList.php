<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Model;

use Umulmrum\Holiday\Filter\HolidayFilterInterface;
use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;

class HolidayList implements \Countable, \IteratorAggregate
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
        if (-1 === $index = $this->getIndexByNameAndDate($holiday->getName(), $holiday->getSimpleDate())) {
            $this->holidayList[] = $holiday;
        } else {
            $this->holidayList[$index] = Holiday::create($holiday->getName(), $holiday->getSimpleDate(), $holiday->getType() | $this->holidayList[$index]->getType());
        }
    }

    public function addAll(HolidayList $holidayList): void
    {
        foreach ($holidayList->getList() as $holiday) {
            $this->add($holiday);
        }
    }

    public function removeByIndex(int $index): void
    {
        \array_splice($this->holidayList, $index, 1);
    }

    public function replaceByIndex(int $index, Holiday $holiday): void
    {
        $this->holidayList[$index] = $holiday;
    }

    private function getIndexByNameAndDate(string $name, string $date): int
    {
        foreach ($this->holidayList as $index => $holiday) {
            if ($name === $holiday->getName() && $date === $holiday->getSimpleDate()) {
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
        $formatted = $date->format(Holiday::DISPLAY_DATE_FORMAT);

        foreach ($this->holidayList as $holiday) {
            if ($holiday->getSimpleDate() === $formatted) {
                return true;
            }
        }

        return false;
    }

    public function filter(HolidayFilterInterface $filter): self
    {
        $filter->filter($this);

        return $this;
    }

    /**
     * @return string|string[]
     */
    public function format(HolidayFormatterInterface $formatter)
    {
        return $formatter->formatList($this);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->holidayList);
    }
}
