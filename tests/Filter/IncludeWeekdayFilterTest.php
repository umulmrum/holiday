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
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class IncludeWeekdayFilterTest extends HolidayTestCase
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
     * @param int      $weekday
     * @param array    $expectedResult
     */
    public function it_should_filter_holidays(array $holidays, $weekday, array $expectedResult)
    {
        $this->givenAnIncludeWeekDayFilter();
        $this->whenFilterIsCalled($holidays, $weekday);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeWeekDayFilter()
    {
        $this->filter = new IncludeWeekdayFilter();
    }

    /**
     * @param array $holidays
     * @param int   $weekday
     */
    private function whenFilterIsCalled(array $holidays, $weekday)
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $holiday) {
            $holidayList->add(new Holiday('name', new DateTime($holiday)));
        }
        $options = [
            IncludeWeekdayFilter::PARAM_WEEK_DAY => $weekday,
        ];
        $this->actualResult = $this->filter->filter($holidayList, $options);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned($expectedResult)
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $resultDates);
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
}
