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

use Umulmrum\Holiday\Filter\SortByTypeFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class SortByTypeFilterTest extends HolidayTestCase
{
    /**
     * @var SortByTypeFilter
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
     * @param int[] $holidays
     * @param int[] $expectedResult
     */
    public function it_should_filter_holidays(array $holidays, array $expectedResult): void
    {
        $this->givenASortByTypeFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenASortByTypeFilter(): void
    {
        $this->filter = new SortByTypeFilter();
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $holidayList = new HolidayList();
        foreach ($holidays as $index => $type) {
            $holidayList->add(Holiday::create("name{$index}", "2020-01-{$index}", $type));
        }
        $this->actualResult = $holidayList->filter($this->filter);
    }

    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultTypes = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultTypes[] = $result->getType();
        }
        self::assertEquals($expectedResult, $resultTypes);
    }

    public function getData(): array
    {
        return [
            [
                [
                    0,
                    1,
                    2,
                ],
                [
                    0,
                    1,
                    2,
                ],
            ],
            [
                [
                    3,
                    2,
                    1,
                ],
                [
                    1,
                    2,
                    3,
                ],
            ],
            [
                [
                    0,
                    0,
                ],
                [
                    0,
                    0,
                ],
            ],
            [
                [
                    0,
                ],
                [
                    0,
                ],
            ],
            [
                [
                    3,
                    1,
                    1,
                ],
                [
                    1,
                    1,
                    3,
                ],
            ],
            [
                [],
                [],
            ],
            [
                [
                    6,
                    6,
                    3,
                    3,
                    1,
                    1,
                ],
                [
                    1,
                    1,
                    3,
                    3,
                    6,
                    6,
                ],
            ],
        ];
    }
}
