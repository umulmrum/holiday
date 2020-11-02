<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Filter;

use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Filter\IncludeWeekdayFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeWeekdayFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeWeekdayFilter
     */
    private $filter;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getData
     *
     * @param string[] $holidays
     */
    public function it_should_filter_holidays(array $holidays, int $weekday, array $expectedResult): void
    {
        $this->givenAnIncludeWeekDayFilter($weekday);
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeWeekDayFilter(int $weekday): void
    {
        $this->filter = new IncludeWeekdayFilter($weekday);
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $date) {
            $holidayList->add(Holiday::create('name', $date));
        }
        $this->actualResult = $holidayList->filter($this->filter);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult as $result) {
            $resultDates[] = $result->getSimpleDate();
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::MONDAY,
                [
                    '2016-01-04',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::TUESDAY,
                [
                    '2016-01-05',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::WEDNESDAY,
                [
                    '2016-01-06',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::THURSDAY,
                [
                    '2016-01-07',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::FRIDAY,
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::SATURDAY,
                [
                    '2016-01-02',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                    '2016-01-04',
                    '2016-01-05',
                    '2016-01-06',
                    '2016-01-07',
                ],
                Weekday::SUNDAY,
                [
                    '2016-01-03',
                ],
            ],
            [
                [],
                Weekday::MONDAY,
                [],
            ],
            [
                [
                    '2015-12-31',
                    '2016-01-02',
                    '2016-01-06',
                    '2016-01-07',
                    '2016-01-14',
                    '2016-01-15',
                    '2016-02-04',
                ],
                Weekday::THURSDAY,
                [
                    '2015-12-31',
                    '2016-01-07',
                    '2016-01-14',
                    '2016-02-04',
                ],
            ],
            [
                [
                    '2016-01-08',
                    '2016-01-08',
                ],
                Weekday::FRIDAY,
                [
                    '2016-01-08',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getDataForException
     *
     * @param mixed $weekdays
     */
    public function it_should_throw_exception_on_invalid_weekdays($weekdays): void
    {
        $this->thenInvalidArgumentExceptionIsExpected();
        $this->whenFilterWithInvalidWeekdayIsInstantiated($weekdays);
    }

    public function getDataForException(): array
    {
        return [
            [[]],
            ['string'],
            [['array', 'of', 'strings']],
            [[Weekday::SATURDAY, 'other']],
            [null],
            [true],
            [-1],
            [7],
            [[3, 7]],
        ];
    }

    private function thenInvalidArgumentExceptionIsExpected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }

    private function whenFilterWithInvalidWeekdayIsInstantiated($weekdays): void
    {
        new IncludeWeekdayFilter($weekdays);
    }
}
