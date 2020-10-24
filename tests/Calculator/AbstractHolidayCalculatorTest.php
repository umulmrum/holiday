<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\HolidayList;

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
     */
    public function it_computes_the_correct_holidays(int $year, array $expectedResult): void
    {
        $this->givenAHolidayCalculator();
        $this->whenICallCalculateHolidaysForYear($year);
        $this->thenTheCorrectHolidaysShouldBeCalculated($expectedResult);
    }

    abstract public function getData(): array;

    private function givenAHolidayCalculator(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

    abstract protected function getHolidayProviders(): array;

    protected function whenICallCalculateHolidaysForYear(int $year): void
    {
        $this->actualResult = $this->holidayCalculator->calculateHolidaysForYear($this->getHolidayProviders(), $year);
    }

    protected function thenTheCorrectHolidaysShouldBeCalculated(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult->getList() as $actualHoliday) {
            $actualResult[] = $actualHoliday->getFormattedDate('Y-m-d');
        }
        sort($actualResult);
        self::assertEquals($expectedResult, $actualResult);
    }
}
