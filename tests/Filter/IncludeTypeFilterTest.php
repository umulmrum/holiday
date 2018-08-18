<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

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
     *
     * @param HolidayList $holidayList
     * @param int         $filterType
     * @param array       $expectedResult
     */
    public function it_should_filter_holidays(HolidayList $holidayList, int $filterType, array $expectedResult)
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
        $this->actualResult = $this->filter->filter($holidayList);
    }

    /**
     * @param string[] $expectedResult
     */
    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        $resultDates = [];
        foreach ($this->actualResult->getList() as $result) {
            $resultDates[] = $result->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public function getData(): array
    {
        return [
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::TRADITIONAL | HolidayType::RELIGIOUS),
                ]),
                HolidayType::DAY_OFF | HolidayType::OFFICIAL,
                [],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::DAY_OFF),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::DAY_OFF),
                    new Holiday('name', new \DateTime('2016-01-02', $this->getTimezone()), HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::DAY_OFF | HolidayType::RELIGIOUS),
                    new Holiday('name', new \DateTime('2016-01-02', $this->getTimezone()), HolidayType::TRADITIONAL),
                ]),
                HolidayType::DAY_OFF,
                [
                    '2016-01-01',
                ],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::DAY_OFF | HolidayType::TRADITIONAL),
                    new Holiday('name', new \DateTime('2016-01-02', $this->getTimezone()), HolidayType::TRADITIONAL),
                ]),
                HolidayType::TRADITIONAL,
                [
                    '2016-01-01',
                    '2016-01-02',
                ],
            ],
            [
                new HolidayList([
                    new Holiday('name', new \DateTime('2016-01-01', $this->getTimezone()), HolidayType::DAY_OFF),
                    new Holiday('name', new \DateTime('2016-01-02', $this->getTimezone()), HolidayType::TRADITIONAL),
                    new Holiday('name', new \DateTime('2016-01-03', $this->getTimezone()), HolidayType::RELIGIOUS),
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
