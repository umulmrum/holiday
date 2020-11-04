<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Calculator;

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

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
        $this->whenICallCalculate($year);
        $this->thenTheCorrectHolidaysShouldBeCalculated($expectedResult);
    }

    abstract protected function getHolidayProviders(): array;

    private function givenAHolidayCalculator(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

    abstract public function getData(): array;

    protected function whenICallCalculate(int $year): void
    {
        $this->actualResult = $this->holidayCalculator->calculate($this->getHolidayProviders(), $year);
    }

    protected function thenTheCorrectHolidaysShouldBeCalculated(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult as $actualHoliday) {
            $actualResult[] = $actualHoliday->getSimpleDate();
        }
        \sort($actualResult);
        self::assertEquals($expectedResult, $actualResult);
    }
}
