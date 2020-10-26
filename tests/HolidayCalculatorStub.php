<?php

namespace umulmrum\Holiday\Test;

use umulmrum\Holiday\HolidayCalculatorInterface;
use umulmrum\Holiday\Model\HolidayList;

final class HolidayCalculatorStub implements HolidayCalculatorInterface
{
    /**
     * @var HolidayList
     */
    private $holidayList;

    public function __construct(HolidayList $holidayList)
    {
        $this->holidayList = $holidayList;
    }

    public function calculate($holidayProviders, $years): HolidayList
    {
        return $this->holidayList;
    }
}
