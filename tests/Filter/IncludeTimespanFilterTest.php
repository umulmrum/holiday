<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use DateTime;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class IncludeTimespanFilterTest extends HolidayTestCase
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
    public function it_should_filter_holidays(array $holidays, $firstDay, $lastDay, array $expectedResult)
    {
        $this->givenAnIncludeTimespanFilter();
        $this->whenFilterIsCalled($holidays, $firstDay, $lastDay);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeTimespanFilter()
    {
        $this->filter = new IncludeTimespanFilter();
    }

    /**
     * @param array  $holidays
     * @param string $firstDay
     * @param string $lastDay
     */
    private function whenFilterIsCalled(array $holidays, $firstDay, $lastDay)
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $holiday) {
            $holidayList->add(new Holiday('name', new DateTime($holiday)));
        }
        $options = [
            IncludeTimespanFilter::PARAM_FIRST_DAY => new DateTime($firstDay),
            IncludeTimespanFilter::PARAM_LAST_DAY => new DateTime($lastDay),
        ];
        $this->actualResult = $this->filter->filter($holidayList, $options);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned($expectedResult)
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getFormattedDate('Y-m-d');
        }
        $this->assertEquals($expectedResult, $resultDates);
    }

    /**
     * @return array
     */
    public function getData()
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
