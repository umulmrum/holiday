<?php

namespace umulmrum\Holiday\Model;

use Countable;
use DateTime;

class HolidayList implements Countable
{
    /**
     * @var Holiday[][]
     */
    private $holidayList = [];
    /**
     * @var
     */
    private $count = 0;

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
    public function add(Holiday $holiday)
    {
        $name = $holiday->getName();
        if (isset($this->holidayList[$name])) {
            /**
             * @var Holiday $tempHoliday
             */
            $found = false;
            foreach ($this->holidayList[$name] as $index => $tempHoliday) {
                if ($tempHoliday->getTimestamp() === $holiday->getTimestamp()) {
                    $this->holidayList[$name][$index] = new Holiday($name, $holiday->getDate(), $holiday->getType() | $tempHoliday->getType());
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->holidayList[$name][] = $holiday;
                ++$this->count;
            }
        } else {
            $this->holidayList[$name] = [];
            $this->holidayList[$name][] = $holiday;
            ++$this->count;
        }
    }

    private function getByNameAndDate($name, DateTime $dateTime)
    {
        $timestamp = $dateTime->getTimestamp();
        foreach ($this->holidayList as $holiday) {
            if ($name === $holiday->getName() && $timestamp === $holiday->getTimestamp()) {
                return $holiday;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->holidayList;
    }

    /**
     * @return Holiday[]
     */
    public function getFlatArray()
    {
        $flattenedArray = [];
        /**
         * @var Holiday[] $holidaysByName
         */
        foreach ($this->holidayList as $holidaysByName) {
            foreach ($holidaysByName as $holidays) {
                $flattenedArray[] = $holidays;
            }
        }

        return $flattenedArray;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->count;
    }
}
