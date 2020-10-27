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

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Filter\IncludeTypeFilter;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeTypeFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeTypeFilter
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
    public function it_should_filter_holidays(HolidayList $holidayList, int $filterType, array $expectedResult): void
    {
        $this->givenAFilter($filterType);
        $this->whenFilterIsCalled($holidayList);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenAFilter(int $filterType): void
    {
        $this->filter = new IncludeTypeFilter($filterType);
    }

    private function whenFilterIsCalled(HolidayList $holidayList): void
    {
        $this->actualResult = $holidayList->filter($this->filter);
    }

    /**
     * @param string[] $expectedResult
     */
    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getSimpleDate();
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::TRADITIONAL | HolidayType::RELIGIOUS),
                ]),
                HolidayType::DAY_OFF | HolidayType::OFFICIAL,
                [],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF),
                    Holiday::create('name', '2016-01-02', HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF | HolidayType::RELIGIOUS),
                    Holiday::create('name', '2016-01-02', HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF | HolidayType::TRADITIONAL),
                    Holiday::create('name', '2016-01-02', HolidayType::TRADITIONAL),
                ]),
                HolidayType::TRADITIONAL,
                [
                    '2016-01-01',
                    '2016-01-02',
                ],
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF),
                    Holiday::create('name', '2016-01-02', HolidayType::TRADITIONAL),
                    Holiday::create('name', '2016-01-03', HolidayType::RELIGIOUS),
                ]),
                HolidayType::DAY_OFF | HolidayType::TRADITIONAL,
                [
                    '2016-01-01',
                    '2016-01-02',
                ],
            ],
        ];
    }
}
