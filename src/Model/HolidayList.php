<?php

namespace umulmrum\Holiday\Model;

use Countable;

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

    public function __construct(array $holidays = [])
    {
        foreach ($holidays as $holiday) {
            $this->add($holiday);
        }
    }

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
