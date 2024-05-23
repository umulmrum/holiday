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
use Umulmrum\Holiday\Filter\IncludeUniqueDateFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeUniqueDateFilterTest extends HolidayTestCase
{
    private IncludeUniqueDateFilter $filter;
    private HolidayList $actualResult;

    /**
     * @param string[] $holidays
     */
    #[DataProvider('getData')]
    #[Test]
    public function it_should_filter_holidays(array $holidays, array $expectedResult): void
    {
        $this->givenAnIncludeUniqueDateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAnIncludeUniqueDateFilter(): void
    {
        $this->filter = new IncludeUniqueDateFilter();
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
