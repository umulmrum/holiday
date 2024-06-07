<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Compensatory;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculator;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Test\HolidayProviderStub;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class CompensatoryDaysCalculatorTest extends HolidayTestCase
{
    private CompensatoryDaysCalculator $subject;

    #[DataProvider('provideDataForAddAll')]
    #[Test]
    public function it_should_calculate_compensatory_days_with_default_settings(HolidayList $initialHolidayList, int $year, HolidayList $expectedHolidayList): void
    {
        $this->givenCompensatoryDaysCalculator();
        $this->whenAddAllIsCalled($initialHolidayList, $year);
        $this->thenHolidayListShouldLookAsExpected($initialHolidayList, $expectedHolidayList);
    }

    public static function provideDataForAddAll(): array
    {
        return [
            'empty' => [
                new HolidayList(),
                2024,
                new HolidayList(),
            ],
            'no-weekend-default' => [
                new HolidayList([Holiday::create('foo', '2024-06-07')]),
                2024,
                new HolidayList([Holiday::create('foo', '2024-06-07')]),
            ],
            'compensatory-sunday' => [
                new HolidayList([Holiday::create('foo', '2024-06-09')]),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                        Holiday::create('foo_compensatory', '2024-06-10', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'compensatory-saturday' => [
                new HolidayList([Holiday::create('foo', '2024-06-08')]),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-08'),
                        Holiday::create('foo_compensatory', '2024-06-10', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'compensatory-sunday-with-types' => [
                new HolidayList([Holiday::create('foo', '2024-06-09', HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF)]),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09', HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF),
                        Holiday::create('foo_compensatory', '2024-06-10', HolidayType::OFFICIAL | HolidayType::HALF_DAY_OFF | HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'multiple' => [
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                        Holiday::create('bar', '2024-01-07'),
                        Holiday::create('baz', '2024-12-29'),
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                        Holiday::create('bar', '2024-01-07'),
                        Holiday::create('baz', '2024-12-29'),
                        Holiday::create('foo_compensatory', '2024-06-10', HolidayType::COMPENSATORY),
                        Holiday::create('bar_compensatory', '2024-01-08', HolidayType::COMPENSATORY),
                        Holiday::create('baz_compensatory', '2024-12-30', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'leap-over-other-holidays' => [
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-08'), // Saturday
                        Holiday::create('bar', '2024-06-10'), // Monday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-08'),
                        Holiday::create('bar', '2024-06-10'),
                        Holiday::create('foo_compensatory', '2024-06-11', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'leap-over-other-holidays-multiple' => [
                new HolidayList(
                    [
                        Holiday::create('wow', '2024-06-07'), // Friday
                        Holiday::create('foo', '2024-06-08'), // Saturday
                        Holiday::create('bar', '2024-06-09'), // Sunday
                        Holiday::create('baz', '2024-06-10'), // Monday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('wow', '2024-06-07'),
                        Holiday::create('foo', '2024-06-08'),
                        Holiday::create('bar', '2024-06-09'),
                        Holiday::create('baz', '2024-06-10'),
                        Holiday::create('foo_compensatory', '2024-06-11', HolidayType::COMPENSATORY),
                        Holiday::create('bar_compensatory', '2024-06-12', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'no-overflow-to-next-year' => [
                new HolidayList([Holiday::create('foo', '2023-12-31')]), // Sunday
                2023,
                new HolidayList([Holiday::create('foo', '2023-12-31')]),
            ],
            'surrender-after-lots-of-tries' => [
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-08'), // Saturday
                        Holiday::create('foo', '2024-06-10'),
                        Holiday::create('foo', '2024-06-11'),
                        Holiday::create('foo', '2024-06-12'),
                        Holiday::create('foo', '2024-06-13'),
                        Holiday::create('foo', '2024-06-14'),
                        Holiday::create('foo', '2024-06-17'),
                        Holiday::create('foo', '2024-06-18'),
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-08'),
                        Holiday::create('foo', '2024-06-10'),
                        Holiday::create('foo', '2024-06-11'),
                        Holiday::create('foo', '2024-06-12'),
                        Holiday::create('foo', '2024-06-13'),
                        Holiday::create('foo', '2024-06-14'),
                        Holiday::create('foo', '2024-06-17'),
                        Holiday::create('foo', '2024-06-18'),
                    ],
                ),
            ],
        ];
    }

    /**
     * @param int[] $forTheseHolidayNamesOnly
     */
    #[DataProvider('provideDataForLimitToHolidays')]
    #[Test]
    public function it_should_be_limitable_to_certain_holidays(
        array $forTheseHolidayNamesOnly,
        HolidayList $initialHolidayList,
        int $year,
        HolidayList $expectedHolidayList,
    ): void {
        $this->givenCompensatoryDaysCalculator(forTheseHolidayNamesOnly: $forTheseHolidayNamesOnly);
        $this->whenAddAllIsCalled($initialHolidayList, $year);
        $this->thenHolidayListShouldLookAsExpected($initialHolidayList, $expectedHolidayList);
    }

    public static function provideDataForLimitToHolidays(): array
    {
        return [
            [
                [
                    'foo',
                    'baz',
                ],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                        Holiday::create('bar', '2024-06-16'),
                        Holiday::create('baz', '2024-06-23'),
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                        Holiday::create('bar', '2024-06-16'),
                        Holiday::create('baz', '2024-06-23'),
                        Holiday::create('foo_compensatory', '2024-06-10', HolidayType::COMPENSATORY),
                        Holiday::create('baz_compensatory', '2024-06-24', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
        ];
    }

    /**
     * @param int[] $weekDaysToStepBackward
     * @param int[] $weekDaysToStepForward
     */
    #[DataProvider('provideDataForSkipCustomWeekDays')]
    #[Test]
    public function it_should_skip_custom_week_days(
        array $weekDaysToStepBackward,
        array $weekDaysToStepForward,
        HolidayList $initialHolidayList,
        int $year,
        HolidayList $expectedHolidayList,
    ): void {
        $this->givenCompensatoryDaysCalculator(weekDaysToStepBackward: $weekDaysToStepBackward, weekDaysToStepForward: $weekDaysToStepForward);
        $this->whenAddAllIsCalled($initialHolidayList, $year);
        $this->thenHolidayListShouldLookAsExpected($initialHolidayList, $expectedHolidayList);
    }

    public static function provideDataForSkipCustomWeekDays(): array
    {
        return [
            'emptyWeekDays' => [
                [],
                [],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'), // Sunday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-09'),
                    ],
                ),
            ],
            'arbitrary-days-forward' => [
                [],
                [Weekday::MONDAY, Weekday::TUESDAY],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-10'), // Monday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-10'),
                        Holiday::create('foo_compensatory', '2024-06-12', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'arbitrary-days-backward' => [
                [Weekday::MONDAY, Weekday::TUESDAY],
                [],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-11'), // Tuesday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-11'),
                        Holiday::create('foo_compensatory', '2024-06-09', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'arbitrary-days-both-directions' => [
                [Weekday::WEDNESDAY],
                [Weekday::FRIDAY],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-12'), // Wednesday
                        Holiday::create('bar', '2024-06-14'), // Friday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-12'),
                        Holiday::create('bar', '2024-06-14'),
                        Holiday::create('foo_compensatory', '2024-06-11', HolidayType::COMPENSATORY),
                        Holiday::create('bar_compensatory', '2024-06-15', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'leap-over-other-holidays' => [
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-07'), // Friday
                        Holiday::create('bar', '2024-06-08'), // Saturday
                        Holiday::create('baz', '2024-06-09'), // Sunday
                        Holiday::create('quux', '2024-06-10'), // Monday
                    ],
                ),
                2024,
                new HolidayList(
                    [
                        Holiday::create('foo', '2024-06-07'),
                        Holiday::create('bar', '2024-06-08'),
                        Holiday::create('baz', '2024-06-09'),
                        Holiday::create('quux', '2024-06-10'),
                        Holiday::create('bar_compensatory', '2024-06-06', HolidayType::COMPENSATORY),
                        Holiday::create('baz_compensatory', '2024-06-11', HolidayType::COMPENSATORY),
                    ],
                ),
            ],
            'no-overflow-to-previous-year' => [
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                new HolidayList([Holiday::create('foo', '2022-01-01')]), // Saturday
                2022,
                new HolidayList([Holiday::create('foo', '2022-01-01')]),
            ],
        ];
    }

    #[Test]
    #[DataProvider('provideDataForAdjacentYears')]
    public function it_should_calculate_days_for_adjacent_years(
        HolidayList $initialHolidays,
        array $weekDaysToStepBackward,
        array $weekDaysToStepForward,
        int $year,
        HolidayProviderInterface $holidayProvider,
        HolidayList $expectedHolidays,
    ): void {
        $this->givenCompensatoryDaysCalculator([], $weekDaysToStepBackward, $weekDaysToStepForward);
        $this->whenAddAllIsCalled($initialHolidays, $year, $holidayProvider);
        $this->thenHolidayListShouldLookAsExpected($initialHolidays, $expectedHolidays);
    }

    public static function provideDataForAdjacentYears(): array
    {
        return [
            'simple-from-previous-year' => [
                new HolidayList([
                    Holiday::create('bar', '2024-05-01'),
                    Holiday::create('baz', '2024-12-31'),
                ]),
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                2024,
                new class() implements HolidayProviderInterface {
                    public function calculateHolidaysForYear(int $year): HolidayList
                    {
                        return new HolidayList([
                            Holiday::create('bar', "{$year}-05-01"),
                            Holiday::create('baz', "{$year}-12-31"),
                        ]);
                    }
                },
                new HolidayList([
                    Holiday::create('bar', '2024-05-01'),
                    Holiday::create('baz', '2024-12-31'),
                    Holiday::create('baz_compensatory', '2024-01-01', HolidayType::COMPENSATORY),
                ]),
            ],
            'from-previous-year-holiday-on-01-01' => [
                new HolidayList([
                    Holiday::create('foo', '2024-01-01'),
                    Holiday::create('bar', '2024-05-01'),
                    Holiday::create('baz', '2024-12-31'),
                ]),
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                2024,
                new class() implements HolidayProviderInterface {
                    public function calculateHolidaysForYear(int $year): HolidayList
                    {
                        return new HolidayList([
                            Holiday::create('foo', "{$year}-01-01"),
                            Holiday::create('bar', "{$year}-05-01"),
                            Holiday::create('baz', "{$year}-12-31"),
                        ]);
                    }
                },
                new HolidayList([
                    Holiday::create('foo', '2024-01-01'),
                    Holiday::create('bar', '2024-05-01'),
                    Holiday::create('baz', '2024-12-31'),
                    Holiday::create('baz_compensatory', '2024-01-02', HolidayType::COMPENSATORY),
                ]),
            ],
            'simple-from-following-year' => [
                new HolidayList([
                    Holiday::create('baz', '2027-01-01'),
                    Holiday::create('bar', '2027-06-01'),
                ]),
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                2027,
                new class() implements HolidayProviderInterface {
                    public function calculateHolidaysForYear(int $year): HolidayList
                    {
                        return new HolidayList([
                            Holiday::create('baz', "{$year}-01-01"),
                            Holiday::create('bar', "{$year}-06-01"),
                        ]);
                    }
                },
                new HolidayList([
                    Holiday::create('baz', '2027-01-01'),
                    Holiday::create('bar', '2027-06-01'),
                    Holiday::create('baz_compensatory', '2027-12-31', HolidayType::COMPENSATORY),
                ]),
            ],
            'from-following-year-holiday-on-12-31' => [
                new HolidayList([
                    Holiday::create('foo', '2027-01-01'),
                    Holiday::create('bar', '2027-06-01'),
                    Holiday::create('baz', '2027-12-31'),
                ]),
                [Weekday::SATURDAY],
                [Weekday::SUNDAY],
                2027,
                new class() implements HolidayProviderInterface {
                    public function calculateHolidaysForYear(int $year): HolidayList
                    {
                        return new HolidayList([
                            Holiday::create('foo', "{$year}-01-01"),
                            Holiday::create('bar', "{$year}-06-01"),
                            Holiday::create('baz', "{$year}-12-31"),
                        ]);
                    }
                },
                new HolidayList([
                    Holiday::create('foo', '2027-01-01'),
                    Holiday::create('bar', '2027-06-01'),
                    Holiday::create('baz', '2027-12-31'),
                    Holiday::create('foo_compensatory', '2027-12-30', HolidayType::COMPENSATORY),
                ]),
            ],
        ];
    }

    private function givenCompensatoryDaysCalculator(
        array $forTheseHolidayNamesOnly = [],
        array $weekDaysToStepBackward = [],
        array $weekDaysToStepForward = [Weekday::SATURDAY, Weekday::SUNDAY],
    ): void {
        $this->subject = new CompensatoryDaysCalculator(
            $forTheseHolidayNamesOnly,
            weekDaysToStepBackward: $weekDaysToStepBackward,
            weekDaysToStepForward: $weekDaysToStepForward,
        );
    }

    private function whenAddAllIsCalled(
        HolidayList $initialHolidayList,
        int $year,
        HolidayProviderInterface $holidayProvider = new HolidayProviderStub(),
    ): void {
        $this->subject->addAll($initialHolidayList, $holidayProvider, $year);
    }

    private function thenHolidayListShouldLookAsExpected(HolidayList $changedHolidayList, HolidayList $expectedHolidayList): void
    {
        self::assertEquals($expectedHolidayList, $changedHolidayList, print_r($changedHolidayList, true));
    }
}
