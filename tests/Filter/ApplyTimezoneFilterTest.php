<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Filter;

use umulmrum\Holiday\Filter\ApplyTimezoneFilter;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

final class ApplyTimezoneFilterTest extends HolidayTestCase
{
    /**
     * @var ApplyTimezoneFilter
     */
    private $filter;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getData
     */
    public function it_should_filter_holidays(array $holidays, string $timezone, array $expectedResult): void
    {
        $this->givenAnApplyTimezoneFilter($timezone);
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnApplyTimezoneFilter(string $timezone): void
    {
        $this->filter = new ApplyTimezoneFilter(new \DateTimeZone($timezone));
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
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getDate();
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                [
                    '2020-01-01',
                ],
                'America/Los_Angeles',
                [
                    new \DateTime('2020-01-01 00:00:00', new \DateTimeZone('America/Los_Angeles')),
                ],
            ],
        ];
    }
}
