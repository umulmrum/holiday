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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

use function sort;

abstract class AbstractHolidayCalculatorTestCase extends HolidayTestCase
{
    protected HolidayCalculator $holidayCalculator;
    protected HolidayList $actualResult;

    #[DataProvider('getData')]
    #[Test]
    public function itComputesTheCorrectHolidays(int $year, array $expectedResult): void
    {
        $this->givenAHolidayCalculator();
        $this->whenICallCalculate($year);
        $this->thenTheCorrectHolidaysShouldBeCalculated($expectedResult);
    }

    abstract public static function getData(): array;

    abstract protected function getHolidayProviders(): array;

    protected function givenAHolidayCalculator(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

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
        sort($actualResult);
        self::assertEquals($expectedResult, $actualResult);
    }
}
