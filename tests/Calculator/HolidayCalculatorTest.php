<?php

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Provider\Germany\Germany;

class HolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    private $holidayCalculator;
    /**
     * @var Holiday[]
     */
    private $actualResult;

    /**
     * @test
     */
    public function it_throws_an_exception_if_country_not_found()
    {
        $this->givenAHolidayCalculatorWithoutInitialization();
        $this->setExpectedException('\umulmrum\Holiday\Exception\HolidayException');
        $this->whenICallCalculateHolidaysForYear(2019, Germany::ID);
    }

    private function givenAHolidayCalculatorWithoutInitialization()
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

    /**
     * @param int    $year
     * @param string $location
     */
    private function whenICallCalculateHolidaysForYear($year, $location)
    {
        $this->actualResult = $this->holidayCalculator->calculateHolidaysForYear($year, $location);
    }
}
