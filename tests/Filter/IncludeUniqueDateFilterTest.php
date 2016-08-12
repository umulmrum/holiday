<?php

namespace umulmrum\Holiday\Filter;

use DateTime;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class IncludeUniqueDateFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeUniqueDateFilter
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
        $this->givenAnIncludeUniqueDateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeUniqueDateFilter()
    {
        $this->filter = new IncludeUniqueDateFilter();
    }

    /**
     * @param array $holidays
     */
    private function whenFilterIsCalled(array $holidays)
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $holiday) {
            $holidayList->add(new Holiday('name', new DateTime($holiday)));
        }
        $this->actualResult = $this->filter->filter($holidayList);
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
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                ],
                [
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
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-01',
                ],
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-03',
                    '2016-01-13',
                    '2016-01-13',
                ],
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-13',
                ],
            ],
        ];
    }
}
