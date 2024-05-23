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
    /**
     * @var HolidayCalculator
     */
    protected $holidayCalculator;

    /**
     * @var HolidayList
     */
    protected $actualResult;

    #[DataProvider('getData')]
    #[Test]
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

    abstract public static function getData(): array;

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
