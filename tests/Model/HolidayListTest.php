<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Model;

use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\FormatterStub;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class HolidayListTest extends HolidayTestCase
{
    private HolidayList $holidayList;

    /**
     * @var bool|string|string[]
     */
    private array|bool|string $actualResult;

    /**
     * @param Holiday[] $presetHolidays
     * @param Holiday[] $expectedHolidays
     */
    #[DataProvider('getAddHolidayData')]
    #[Test]
    public function it_should_add_a_holiday(array $presetHolidays, Holiday $holiday, array $expectedHolidays): void
    {
        $this->givenAHolidayList($presetHolidays);
        $this->whenAddHolidayIsCalled($holiday);
        $this->thenTheListShouldContainCertainHolidays($expectedHolidays);
    }

    /**
     * @param Holiday[] $presetHolidays
     */
    private function givenAHolidayList(array $presetHolidays): void
    {
        $this->holidayList = new HolidayList();
        foreach ($presetHolidays as $holiday) {
            $this->holidayList->add($holiday);
        }
    }

    private function whenAddHolidayIsCalled(Holiday $holiday): void
    {
        $this->holidayList->add($holiday);
    }

    /**
     * @param Holiday[] $expectedValue
     */
    private function thenTheListShouldContainCertainHolidays(array $expectedValue): void
    {
        self::assertEquals($expectedValue, $this->holidayList->getList());
    }

    public static function getAddHolidayData(): array
    {
        $holiday1 = Holiday::create('name1', '2003-02-06', HolidayType::OFFICIAL);
        $holiday2 = Holiday::create('name2', '2003-04-07', HolidayType::OFFICIAL);
        $holiday2a = Holiday::create('name2', '2003-04-07', HolidayType::RELIGIOUS);
        $holiday2b = Holiday::create('name2', '2003-04-07', HolidayType::OFFICIAL | HolidayType::RELIGIOUS);
        $holiday2c = Holiday::create('name2', '2003-12-12', HolidayType::OFFICIAL | HolidayType::RELIGIOUS);

        return [
            [
                [],
                $holiday1,
                [
                    $holiday1,
                ],
            ],
            [
                [
                    $holiday1,
                ],
                $holiday2,
                [
                    $holiday1,
                    $holiday2,
                ],
            ],
            [
                [
                    $holiday2,
                ],
                $holiday2a,
                [
                    $holiday2b,
                ],
            ],
            [
                [
                    $holiday1,
                    $holiday2,
                ],
                $holiday2a,
                [
                    $holiday1,
                    $holiday2b,
                ],
            ],
            [
                [
                    $holiday2,
                ],
                $holiday2c,
                [
                    $holiday2,
                    $holiday2c,
                ],
            ],
        ];
    }

    /**
     * @param Holiday[] $presetHolidays
     * @param Holiday[] $expectedResult
     */
    #[Test]
    #[DataProvider('provideDataForRemoveByName')]
    public function it_should_remove_holidays_by_name(array $presetHolidays, string $nameToRemove, array $expectedResult): void
    {
        $this->givenAHolidayList($presetHolidays);
        $this->whenRemoveByNameIsCalled($nameToRemove);
        $this->thenTheListShouldBeAsExpected($expectedResult);
    }

    public static function provideDataForRemoveByName(): array
    {
        return [
            'empty' => [
                [],
                'foo',
                [],
            ],
            'result-will-be-empty' => [
                [
                    Holiday::create('name1', '2024-01-01'),
                ],
                'name1',
                [],
            ],
            'unaffected' => [
                [
                    Holiday::create('name1', '2024-01-01'),
                ],
                'another-name',
                [
                    Holiday::create('name1', '2024-01-01'),
                ],
            ],
            'retain-others' => [
                [
                    Holiday::create('name1', '2024-01-01'),
                    Holiday::create('name2', '2024-01-01'),
                    Holiday::create('name3', '2024-01-01'),
                ],
                'name1',
                [
                    Holiday::create('name2', '2024-01-01'),
                    Holiday::create('name3', '2024-01-01'),
                ],
            ],
            'remove-multiple' => [
                [
                    Holiday::create('name1', '2024-01-01'),
                    Holiday::create('name1', '2024-01-01'),
                    Holiday::create('name2', '2024-01-01'),
                    Holiday::create('name1', '2024-01-01'),
                ],
                'name1',
                [
                    Holiday::create('name2', '2024-01-01'),
                ],
            ],
        ];
    }

    private function whenRemoveByNameIsCalled(string $nameToRemove): void
    {
        $this->holidayList->removeByName($nameToRemove);
    }

    private function thenTheListShouldBeAsExpected(array $expectedResult): void
    {
        self::assertEquals($this->holidayList->getList(), $expectedResult);
    }

    #[DataProvider('provideDataForReplaceByNameAndDate')]
    #[Test]
    public function it_should_replace_by_name_and_date(array $presetHolidays, Holiday $holidayToReplace, array $expectedResult): void
    {
        $this->givenAHolidayList($presetHolidays);
        $this->whenReplaceByNameAndDateIsCalled($holidayToReplace);
        $this->thenTheListShouldBeAsExpected($expectedResult);
    }

    public static function provideDataForReplaceByNameAndDate(): array
    {
        return [
            'empty' => [
                [],
                Holiday::create('name1', '2024-01-01'),
                [
                    Holiday::create('name1', '2024-01-01'),
                ],
            ],
            'not-in-list' => [
                [
                    Holiday::create('foo', '2024-01-01'),
                    Holiday::create('bar', '2024-01-01'),
                    Holiday::create('name1', '2024-01-02'),
                ],
                Holiday::create('name1', '2024-01-01'),
                [
                    Holiday::create('foo', '2024-01-01'),
                    Holiday::create('bar', '2024-01-01'),
                    Holiday::create('name1', '2024-01-02'),
                    Holiday::create('name1', '2024-01-01'),
                ],
            ],
            'other-types' => [
                [
                    Holiday::create('name1', '2024-01-02', HolidayType::OFFICIAL | HolidayType::DAY_OFF),
                ],
                Holiday::create('name1', '2024-01-02', HolidayType::RELIGIOUS),
                [
                    Holiday::create('name1', '2024-01-02', HolidayType::RELIGIOUS),
                ],
            ],
        ];
    }

    private function whenReplaceByNameAndDateIsCalled(Holiday $holiday): void
    {
        $this->holidayList->replaceByNameAndDate($holiday);
    }

    #[DataProvider('provideDataForContainsDate')]
    #[Test]
    public function it_should_check_if_is_holiday(array $presetHolidays, string $date, bool $expectedResult): void
    {
        $this->givenAHolidayList($presetHolidays);
        $this->whenIsHolidayIsCalled($date);
        $this->thenItShouldReturnIfDateIsHoliday($expectedResult);
    }

    public static function provideDataForContainsDate(): array
    {
        $holiday1 = Holiday::create('name1', '2003-02-06', HolidayType::OFFICIAL);
        $holiday2 = Holiday::create('name2', '2003-04-07', HolidayType::OFFICIAL);

        return [
            [
                [],
                '2020-10-10',
                false,
            ],
            [
                [
                    $holiday1,
                    $holiday2,
                ],
                '2020-10-10',
                false,
            ],
            [
                [
                    $holiday1,
                    $holiday2,
                ],
                '2003-02-06',
                true,
            ],
            [
                [
                    $holiday1,
                    $holiday2,
                ],
                '2003-04-07',
                true,
            ],
        ];
    }

    private function whenIsHolidayIsCalled(string $date): void
    {
        $this->actualResult = $this->holidayList->isHoliday(DateTime::createFromFormat('Y-m-d', $date)); // @phpstan-ignore-line
    }

    private function thenItShouldReturnIfDateIsHoliday(bool $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    #[Test]
    public function it_should_format_lists(): void
    {
        $this->givenSomeHolidayList();
        $this->whenFormatIsCalledWithAFormatter();
        $this->thenTheFormattedResultShouldBeReturned();
    }

    private function givenSomeHolidayList(): void
    {
        $this->holidayList = new HolidayList([
            Holiday::create('name1', '2020-01-01'),
            Holiday::create('name2', '2020-12-31', HolidayType::DAY_OFF),
        ]);
    }

    private function whenFormatIsCalledWithAFormatter(): void
    {
        $this->actualResult = $this->holidayList->format(new FormatterStub());
    }

    private function thenTheFormattedResultShouldBeReturned(): void
    {
        self::assertEquals('name1|2020-01-01|0;name2|2020-12-31|2', $this->actualResult);
    }
}
