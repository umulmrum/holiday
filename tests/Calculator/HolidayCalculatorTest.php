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
use umulmrum\Holiday\Provider\Germany\Germany;

class HolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    private $holidayCalculator;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     */
    public function it_computes_the_correct_holidays_if_manually_initialized(): void
    {
        $this->givenAHolidayCalculatorWithManualInitialization();
        $this->whenICallCalculateHolidaysForYear(2019);
        $this->thenTheCorrectHolidaysShouldBeCalculated([
            '2019-01-01',
            '2019-04-19',
            '2019-04-21',
            '2019-04-22',
            '2019-05-01',
            '2019-05-30',
            '2019-06-09',
            '2019-06-10',
            '2019-10-03',
            '2019-10-31',
            '2019-11-20',
            '2019-12-25',
            '2019-12-26',
        ]);
    }

    private function givenAHolidayCalculatorWithManualInitialization(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
        $this->holidayCalculator->addHolidayProvider(new Germany());
    }

    private function whenICallCalculateHolidaysForYear(int $year): void
    {
        $this->actualResult = $this->holidayCalculator->calculateHolidaysForYear($year);
    }

    protected function thenTheCorrectHolidaysShouldBeCalculated(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult->getList() as $actualHoliday) {
            $actualResult[] = $actualHoliday->getFormattedDate('Y-m-d');
        }
        sort($actualResult);
        $this->assertEquals($expectedResult, $actualResult);
    }
}
