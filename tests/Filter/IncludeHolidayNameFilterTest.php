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

use Umulmrum\Holiday\Filter\IncludeHolidayNameFilter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class IncludeHolidayNameFilterTest extends HolidayTestCase
{
    /**
     * @var IncludeHolidayNameFilter
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
     * @param string|string[] $holidayNames
     * @param Holiday[]       $expectedResult
     */
    public function it_should_filter_holidays(HolidayList $holidayList, $holidayNames, array $expectedResult): void
    {
        $this->givenAFilter($holidayNames);
        $this->whenFilterIsCalled($holidayList);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    public function getData(): array
    {
        return [
            'not found' => [
                new HolidayList([
                    Holiday::create('name', '2021-01-01'),
                ]),
                'foo',
                [],
            ],
            'single' => [
                new HolidayList([
                    Holiday::create('name', '2021-01-01'),
                ]),
                'name',
                [
                    Holiday::create('name', '2021-01-01'),
                ],
            ],
            'one match on same date' => [
                new HolidayList([
                    Holiday::create('name', '2021-01-01'),
                    Holiday::create('foo', '2021-01-01'),
                ]),
                'name',
                [
                    Holiday::create('name', '2021-01-01'),
                ],
            ],
            'two matches' => [
                new HolidayList([
                    Holiday::create('name', '2021-01-01'),
                    Holiday::create('name', '2021-01-02'),
                ]),
                'name',
                [
                    Holiday::create('name', '2021-01-01'),
                    Holiday::create('name', '2021-01-02'),
                ],
            ],
            'multiple matches' => [
                new HolidayList([
                    Holiday::create('foo', '2021-01-01'),
                    Holiday::create('bar', '2021-01-02'),
                    Holiday::create('name', '2021-01-03'),
                    Holiday::create('name', '2021-01-04'),
                    Holiday::create('name2', '2021-01-05'),
                    Holiday::create('name', '2021-01-06'),
                ]),
                'name',
                [
                    Holiday::create('name', '2021-01-03'),
                    Holiday::create('name', '2021-01-04'),
                    Holiday::create('name', '2021-01-06'),
                ],
            ],

            'multiple distinct names' => [
                new HolidayList([
                    Holiday::create('name', '2021-01-01'),
                    Holiday::create('foo', '2021-01-02'),
                    Holiday::create('bar', '2021-01-03'),
                ]),
                ['name', 'bar'],
                [
                    Holiday::create('name', '2021-01-01'),
                    Holiday::create('bar', '2021-01-03'),
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getDataForException
     */
    public function it_should_throw_exception_on_invalid_holiday_names($holidayName): void
    {
        $this->thenInvalidArgumentExceptionIsExpected();
        $this->whenFilterWithInvalidHolidayNameIsInstantiated($holidayName);
    }

    public function getDataForException(): array
    {
        return [
            [42],
            [null],
            [true],
            [['string', 1337]],
            [[null, 'string']],
        ];
    }

    /**
     * @param string|string[] $holidayNames
     */
    private function givenAFilter($holidayNames): void
    {
        $this->filter = new IncludeHolidayNameFilter($holidayNames);
    }

    private function whenFilterIsCalled(HolidayList $holidayList): void
    {
        $this->actualResult = $holidayList->filter($this->filter);
    }

    /**
     * @param Holiday[] $expectedResult
     */
    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult->getList());
    }

    private function thenInvalidArgumentExceptionIsExpected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }

    private function whenFilterWithInvalidHolidayNameIsInstantiated($holidayName): void
    {
        new IncludeHolidayNameFilter($holidayName);
    }
}
