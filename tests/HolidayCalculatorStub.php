<?php

namespace Umulmrum\Holiday\Test;

use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\HolidayList;

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
