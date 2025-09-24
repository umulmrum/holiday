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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Filter\SortByDateFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class SortByDateFilterTest extends HolidayTestCase
{
    private SortByDateFilter $filter;
    private HolidayList $actualResult;

    /**
     * @param string[] $holidays
     * @param string[] $expectedResult
     */
    #[DataProvider('getData')]
    #[Test]
    public function itShouldFilterHolidays(array $holidays, array $expectedResult): void
    {
        $this->givenASortByDateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    public static function getData(): array
    {
        return [
            [
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                ],
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                ],
            ],
            [
                [
                    '2016-01-03',
                    '2016-01-02',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-01-03',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-03',
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                ],
            ],
            [
                [],
                [],
            ],
            [
                [
                    '2016-01-13',
                    '2016-01-13',
                    '2016-01-03',
                    '2016-01-03',
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-03',
                    '2016-01-13',
                    '2016-01-13',
                ],
            ],
            [
                [
                    '2016-01-13',
                    '2015-01-13',
                    '2014-01-03',
                    '2013-01-03',
                    '2012-01-01',
                    '2011-01-01',
                ],
                [
                    '2011-01-01',
                    '2012-01-01',
                    '2013-01-03',
                    '2014-01-03',
                    '2015-01-13',
                    '2016-01-13',
                ],
            ],
        ];
    }

    private function givenASortByDateFilter(): void
    {
        $this->filter = new SortByDateFilter();
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $index => $date) {
            $holidayList->add(Holiday::create('name' . $index, $date));
        }
        $this->actualResult = $holidayList->filter($this->filter);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getSimpleDate();
        }
        self::assertEquals($expectedResult, $resultDates);
    }
}
