<?php

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayInitializerInterface;

abstract class AbstractHolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    protected $holidayCalculator;
    /**
     * @var HolidayList
     */
    protected $actualResult;

    /**
     * @test
     * @dataProvider getData
     *
     * @param int    $year
     * @param string $location
     * @param array  $expectedResult
     */
    public function it_computes_the_correct_holidays($year, $location, array $expectedResult)
    {
        $this->givenAHolidayCalculator();
        $this->whenICallCalculateHolidaysForYear($year, $location);
        $this->thenTheCorrectHolidaysShouldBeCalculated($expectedResult);
    }

    /**
     * @return array
     */
    abstract public function getData();

    private function givenAHolidayCalculator()
    {
        $this->holidayCalculator = new HolidayCalculator($this->getHolidayInitializer());
    }

    /**
     * @return HolidayInitializerInterface
     */
    abstract protected function getHolidayInitializer();

    /**
     * @param int    $year
     * @param string $location
     * @param string $zip
     */
    protected function whenICallCalculateHolidaysForYear($year, $location)
    {
        $this->actualResult = $this->holidayCalculator->calculateHolidaysForYear($year, $location);
    }

    /**
     * @param array $expectedResult
     */
    protected function thenTheCorrectHolidaysShouldBeCalculated(array $expectedResult)
    {
        $actualResult = [];
        foreach ($this->actualResult->getFlatArray() as $actualHoliday) {
            $actualResult[] = $actualHoliday->getFormattedDate('Y-m-d');
        }
        sort($actualResult);
        $this->assertEquals($expectedResult, $actualResult);
    }
}
