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

use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Filter\IncludeTimespanFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeTimespanFilterTest extends HolidayTestCase
{
    private IncludeTimespanFilter $filter;
    private HolidayList $actualResult;

    /**
     * @param string[] $holidays
     */
    #[DataProvider('getData')]
    #[Test]
    public function itShouldFilterHolidays(array $holidays, string $firstDay, string $lastDay, array $expectedResult): void
    {
        $this->givenAnIncludeTimespanFilter($firstDay, $lastDay);
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    public static function getData(): array
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
                '2016-01-01 00:00:00',
                '2016-12-31 23:59:59',
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

    private function givenAnIncludeTimespanFilter(string $firstDay, string $lastDay): void
    {
        $this->filter = new IncludeTimespanFilter(new DateTime($firstDay), new DateTime($lastDay));
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
}
