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
use Umulmrum\Holiday\Filter\SortByNameFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class SortByNameFilterTest extends HolidayTestCase
{
    private SortByNameFilter $filter;
    private HolidayList $actualResult;

    /**
     * @param string[] $holidays
     * @param string[] $expectedResult
     */
    #[DataProvider('getData')]
    #[Test]
    public function itShouldFilterHolidays(array $holidays, array $expectedResult): void
    {
        $this->givenASortByNameFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    public static function getData(): array
    {
        return [
            [
                [
                    'a',
                    'b',
                    'c',
                ],
                [
                    'a',
                    'b',
                    'c',
                ],
            ],
            [
                [
                    'c',
                    'b',
                    'a',
                ],
                [
                    'a',
                    'b',
                    'c',
                ],
            ],
            [
                [
                    'a',
                    'a',
                ],
                [
                    'a',
                    'a',
                ],
            ],
            [
                [
                    'a',
                ],
                [
                    'a',
                ],
            ],
            [
                [
                    'c',
                    'a',
                    'a',
                ],
                [
                    'a',
                    'a',
                    'c',
                ],
            ],
            [
                [],
                [],
            ],
            [
                [
                    'f',
                    'f',
                    'c',
                    'c',
                    'a',
                    'a',
                ],
                [
                    'a',
                    'a',
                    'c',
                    'c',
                    'f',
                    'f',
                ],
            ],
        ];
    }

    private function givenASortByNameFilter(): void
    {
        $this->filter = new SortByNameFilter();
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $index => $name) {
            $holidayList->add(Holiday::create($name, "2020-01-0{$index}"));
        }
        $this->actualResult = $holidayList->filter($this->filter);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultNames = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultNames[] = $result->getName();
        }
        self::assertEquals($expectedResult, $resultNames);
    }
}
