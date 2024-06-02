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

use ArrayIterator;
use Countable;
use DateTimeInterface;
use IteratorAggregate;
use Traversable;
use Umulmrum\Holiday\Filter\HolidayFilterInterface;
use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;

use function array_splice;
use function count;

/**
 * @implements IteratorAggregate<int, Holiday>
 */
class HolidayList implements Countable, IteratorAggregate
{
    /**
     * @var array<int, Holiday>
     */
    private array $holidayList = [];

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

    public function removeByName(string $name): void
    {
        $count = $this->count();
        for ($index = $count - 1; $index >= 0; --$index) {
            if ($this->holidayList[$index]->getName() === $name) {
                $this->removeByIndex($index);
            }
        }
    }

    public function removeByIndex(int $index): void
    {
        array_splice($this->holidayList, $index, 1);
    }

    /**
     * Replaces an existing holiday in the list, identifying it by name and date. If the holiday does not exist yet in
     * the list, it will be added instead.
     * Use this method to get rid of types, but use the add method if you only intend to add types, as it will retain
     * existing ones.
     */
    public function replaceByNameAndDate(Holiday $holiday): void
    {
        if (-1 === $index = $this->getIndexByNameAndDate($holiday->getName(), $holiday->getSimpleDate())) {
            $this->holidayList[] = $holiday;
        } else {
            $this->holidayList[$index] = $holiday;
        }
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
     * @return array<int, Holiday>
     */
    public function getList(): array
    {
        return $this->holidayList;
    }

    public function count(): int
    {
        return count($this->holidayList);
    }

    /**
     * @return array<int, Holiday>
     */
    public function getByName(string $name): array
    {
        $result = [];
        foreach ($this->holidayList as $holiday) {
            if ($holiday->getName() === $name) {
                $result[] = $holiday;
            }
        }

        return $result;
    }

    public function isHoliday(DateTimeInterface $date): bool
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
    public function format(HolidayFormatterInterface $formatter): array|string
    {
        return $formatter->formatList($this);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->holidayList);
    }
}
