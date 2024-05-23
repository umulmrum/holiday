<?php

namespace Umulmrum\Holiday\Test;

use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\HolidayList;

final readonly class HolidayCalculatorStub implements HolidayCalculatorInterface
{
    public function __construct(private HolidayList $holidayList) {}

    public function calculate($holidayProviders, $years): HolidayList
    {
        return $this->holidayList;
    }
}
