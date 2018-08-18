<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

final class IncludeTimespanFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeTimespanFilter
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
     * @param string   $firstDay
     * @param string   $lastDay
     * @param array    $expectedResult
     */
    public function it_should_filter_holidays(array $holidays, string $firstDay, string $lastDay, array $expectedResult): void
    {
        $this->givenAnIncludeTimespanFilter($firstDay, $lastDay);
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeTimespanFilter(string $firstDay, string $lastDay): void
    {
        $this->filter = new IncludeTimespanFilter(new \DateTime($firstDay), new \DateTime($lastDay));
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $holiday) {
            $holidayList->add(new Holiday('name', new \DateTime($holiday)));
        }
        $this->actualResult = $this->filter->filter($holidayList);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned($expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getFormattedDate('Y-m-d');
        }
        $this->assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-03',
                '2016-01-07',
                [
                    '2016-01-05',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-01',
                '2016-01-07',
                [
                    '2016-01-01',
                    '2016-01-05',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2015-12-31',
                '2016-01-07',
                [
                    '2016-01-01',
                    '2016-01-05',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-03',
                '2016-12-31',
                [
                    '2016-01-05',
                    '2016-12-31',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-03',
                '2017-01-07',
                [
                    '2016-01-05',
                    '2016-12-31',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-01',
                '2016-12-31',
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2015-12-31',
                '2017-01-01',
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-01',
                '2016-01-01',
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-05',
                    '2016-12-31',
                ],
                '2016-01-02',
                '2016-01-04',
                [
                ],
            ],
            [
                [
                ],
                '2016-01-01',
                '2016-12-31',
                [
                ],
            ],
        ];
    }
}
