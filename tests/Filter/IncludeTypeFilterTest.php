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

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Filter\IncludeTypeFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

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
     *
     * @param int|int[] $filterType
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getData')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_filter_holidays(HolidayList $holidayList, $filterType, array $expectedResult): void
    {
        $this->givenAFilter($filterType);
        $this->whenFilterIsCalled($holidayList);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    /**
     * @param int|int[] $filterType
     */
    private function givenAFilter($filterType): void
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
        foreach ($this->actualResult as $result) {
            $resultDates[] = $result->getSimpleDate();
        }
        self::assertEquals($expectedResult, $resultDates);
    }

    public static function getData(): array
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
            [
                new HolidayList([
                    Holiday::create('name', '2016-01-01', HolidayType::DAY_OFF),
                    Holiday::create('name', '2016-01-02', HolidayType::TRADITIONAL),
                    Holiday::create('name', '2016-01-03', HolidayType::RELIGIOUS),
                ]),
                [HolidayType::DAY_OFF, HolidayType::TRADITIONAL],
                [
                    '2016-01-01',
                    '2016-01-02',
                ],
            ],
        ];
    }

    /**
     *
     * @param mixed $filterType
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getDataForException')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_throw_exception_on_invalid_holiday_types($filterType): void
    {
        $this->thenInvalidArgumentExceptionIsExpected();
        $this->whenFilterWithInvalidTypeIsInstantiated($filterType);
    }

    public static function getDataForException(): array
    {
        return [
            ['string'],
            [['array', 'of', 'strings']],
            [[HolidayType::DAY_OFF, 'other']],
            [null],
            [true],
        ];
    }

    private function thenInvalidArgumentExceptionIsExpected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }

    /**
     * @param int|int[] $filterType
     */
    private function whenFilterWithInvalidTypeIsInstantiated($filterType): void
    {
        new IncludeTypeFilter($filterType);
    }
}
