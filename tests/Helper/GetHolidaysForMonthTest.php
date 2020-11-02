<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Helper;

use Umulmrum\Holiday\Helper\GetHolidaysForMonth;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Test\HolidayCalculatorStub;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class GetHolidaysForMonthTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculatorStub;
    /**
     * @var GetHolidaysForMonth
     */
    private $subject;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getGetHolidaysForMonthData
     */
    public function it_should_calculate_a_list_of_all_holidays_in_a_given_month(int $year, int $month, array $existingHolidays, array $expectedResult): void
    {
        $this->givenHolidayCalculatorReturningHolidays($year, $existingHolidays);
        $this->givenGetHolidaysForMonth();
        $this->whenGetHolidaysForMonthIsCalled($year, $month);
        $this->thenExpectedHolidaysShouldBeReturned($expectedResult);
    }

    public function getGetHolidaysForMonthData(): array
    {
        return [
            [
                2016,
                2,
                [
                    '2016-01-31',
                    '2016-02-01',
                    '2016-02-15',
                    '2016-02-28',
                    '2016-02-29',
                    '2016-03-01',
                ],
                [
                    '2016-02-01',
                    '2016-02-15',
                    '2016-02-28',
                    '2016-02-29',
                ],
            ],
            [
                2016,
                11,
                [
                    '2016-11-01',
                ],
                [
                    '2016-11-01',
                ],
            ],
            [
                2016,
                11,
                [
                    '2016-10-03',
                ],
                [],
            ],
            [
                2016,
                3,
                [],
                [],
            ],
        ];
    }

    private function givenHolidayCalculatorReturningHolidays(int $year, array $existingHolidays): void
    {
        $this->holidayCalculatorStub = new HolidayCalculatorStub($this->getHolidayList($existingHolidays));
    }

    private function getHolidayList(array $data): HolidayList
    {
        $holidayList = new HolidayList();
        foreach ($data as $element) {
            if (true === \is_string($element)) {
                $holidayList->add(Holiday::create('foo', $element));
            } else {
                $holidayList->add($element);
            }
        }

        return $holidayList;
    }

    private function givenGetHolidaysForMonth(): void
    {
        $this->subject = new GetHolidaysForMonth($this->holidayCalculatorStub);
    }

    private function whenGetHolidaysForMonthIsCalled(int $year, int $month): void
    {
        $this->actualResult = ($this->subject)(Germany::class, $year, $month);
    }

    private function thenExpectedHolidaysShouldBeReturned(array $expectedResult): void
    {
        self::assertEquals($this->getHolidayList($expectedResult), $this->actualResult);
    }
}
