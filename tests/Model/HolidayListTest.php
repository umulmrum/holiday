<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Model;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\HolidayTestCase;

final class HolidayListTest extends HolidayTestCase
{
    /**
     * @var HolidayList
     */
    private $holidayList;
    /**
     * @var bool
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getAddHolidayData
     *
     * @param Holiday[] $presetHolidays
     * @param Holiday[] $expectedHolidays
     */
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

    public function getAddHolidayData(): array
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
     * @test
     * @dataProvider provideDataForContainsDate
     */
    public function it_should_check_if_is_holiday(array $presetHolidays, string $date, bool $expectedResult): void
    {
        $this->givenAHolidayList($presetHolidays);
        $this->whenIsHolidayIsCalled($date);
        $this->thenItShouldReturnIfDateIsHoliday($expectedResult);
    }

    public function provideDataForContainsDate(): array
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
        $this->actualResult = $this->holidayList->isHoliday(\DateTime::createFromFormat('!Y-m-d', $date));
    }

    private function thenItShouldReturnIfDateIsHoliday(bool $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }
}
