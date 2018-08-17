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

class HolidayListTest extends HolidayTestCase
{
    /**
     * @var HolidayList
     */
    private $holidayList;

    /**
     * @test
     * @dataProvider getAddHolidayData
     *
     * @param Holiday[] $presetHolidays
     * @param Holiday   $holiday
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

    /**
     * @return array
     */
    public function getAddHolidayData(): array
    {
        $holiday1 = new Holiday('name1', new \DateTime('2003-02-06'), HolidayType::OFFICIAL);
        $holiday2 = new Holiday('name2', new \DateTime('2003-04-07'), HolidayType::OFFICIAL);
        $holiday2a = new Holiday('name2', new \DateTime('2003-04-07'), HolidayType::RELIGIOUS);
        $holiday2b = new Holiday('name2', new \DateTime('2003-04-07'), HolidayType::OFFICIAL | HolidayType::RELIGIOUS);
        $holiday2c = new Holiday('name2', new \DateTime('2003-12-12'), HolidayType::OFFICIAL | HolidayType::RELIGIOUS);

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
}
