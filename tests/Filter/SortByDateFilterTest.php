<?php

namespace umulmrum\Holiday\Filter;

use DateTime;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class SortByDateFilterTest extends HolidayTestCase
{
    /**
     * @var SortByDateFilterTest
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
     * @param array    $expectedResult
     */
    public function it_should_filter_holidays(array $holidays, array $expectedResult)
    {
        $this->givenASortByDateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenASortByDateFilter()
    {
        $this->filter = new SortByDateFilter();
    }

    /**
     * @param array $holidays
     */
    private function whenFilterIsCalled(array $holidays)
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $index => $holiday) {
            $holidayList->add(new Holiday('name' . $index, new DateTime($holiday)));
        }
        $this->actualResult = $this->filter->filter($holidayList);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned($expectedResult)
    {
        $resultDates = [];
        foreach ($this->actualResult->getFlatArray() as $result) {
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
}
