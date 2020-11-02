<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Helper;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Helper\GetHolidaysByName;
use Umulmrum\Holiday\Helper\GetHolidaysForMonth;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Test\HolidayCalculatorStub;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class GetHolidaysByNameTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculatorStub;
    /**
     * @var GetHolidaysForMonth
     */
    private $subject;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getGetHolidaysByNameData
     */
    public function it_should_calculate_correct_holidays_for_a_holiday_name(int $year, array $existingHolidays, string $holidayName, array $expectedResult): void
    {
        $this->givenHolidayCalculatorReturningHolidays($year, $existingHolidays);
        $this->givenGetHolidaysByName();
        $this->whenGetHolidaysByNameIsCalled($year, $holidayName);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    public function getGetHolidaysByNameData(): array
    {
        return [
            [
                2016,
                [
                    Holiday::create(HolidayName::NEW_YEAR, '2016-01-01'),
                    Holiday::create(HolidayName::ALL_SAINTS_DAY, '2016-11-01'),
                    Holiday::create(HolidayName::CHRISTMAS_DAY, '2016-12-25'),
                ],
                HolidayName::ALL_SAINTS_DAY,
                [
                    '2016-11-01',
                ],
            ],
            [
                2016,
                [
                    Holiday::create(HolidayName::NEW_YEAR, '2016-01-01'),
                    Holiday::create(HolidayName::ALL_SAINTS_DAY, '2016-11-01'),
                    Holiday::create(HolidayName::CHRISTMAS_DAY, '2016-12-25'),
                ],
                HolidayName::LABOR_DAY,
                [],
            ],
            [
                2016,
                [
                    Holiday::create(HolidayName::NEW_YEAR, '2016-01-01'),
                    Holiday::create(HolidayName::SUNDAY, '2016-11-06'),
                    Holiday::create(HolidayName::SUNDAY, '2016-11-13'),
                ],
                HolidayName::SUNDAY,
                [
                    '2016-11-06',
                    '2016-11-13',
                ],
            ],
        ];
    }

    private function givenGetHolidaysByName(): void
    {
        $this->subject = new GetHolidaysByName($this->holidayCalculatorStub);
    }

    private function givenHolidayCalculatorReturningHolidays(int $year, array $existingHolidays): void
    {
        $this->holidayCalculatorStub = new HolidayCalculatorStub($this->getHolidayList($existingHolidays));
    }

    private function getHolidayList(array $data): HolidayList
    {
        $holidayList = new HolidayList();
        foreach ($data as $element) {
            if (true === \is_string($element)) {
                $holidayList->add(Holiday::create('foo', $element));
            } else {
                $holidayList->add($element);
            }
        }

        return $holidayList;
    }

    private function thenItShouldReturnAListOfHolidays(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult as $holiday) {
            $actualResult[] = $holiday->getSimpleDate();
        }
        self::assertEquals($expectedResult, $actualResult);
    }

    private function whenGetHolidaysByNameIsCalled(int $year, string $holidayName): void
    {
        $this->actualResult = ($this->subject)(Germany::class, $year, $holidayName);
    }
}
