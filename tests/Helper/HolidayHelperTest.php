<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Helper;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Helper\HolidayHelper;
use umulmrum\Holiday\Test\DateProviderStub;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Germany\Germany;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Provider\Weekday\Thursdays;
use umulmrum\Holiday\Provider\Weekday\Tuesdays;
use umulmrum\Holiday\Test\TranslatorStub;

final class HolidayHelperTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculatorInterface|ObjectProphecy
     */
    private $holidayCalculatorMock;
    /**
     * @var HolidayHelper
     */
    private $holidayHelper;
    /**
     * @var HolidayList
     */
    private $actualResult;

    protected function setUp(): void
    {
        parent::setUp();
        $this->holidayCalculatorMock = $this->prophesize(HolidayCalculatorInterface::class);
    }

    private function givenHolidayHelper(): void
    {
        if ($this->holidayCalculatorMock instanceof ObjectProphecy) {
            $this->holidayHelper = new HolidayHelper($this->holidayCalculatorMock->reveal());
        } else {
            $this->holidayHelper = new HolidayHelper($this->holidayCalculatorMock);
        }
    }

    /**
     * @test
     * @dataProvider getGetHolidaysForMonthData
     */
    public function it_should_calculate_a_list_of_all_holidays_in_a_given_month(int $year, int $month, array $existingHolidays, array $expectedResult): void
    {
        $this->givenHolidayCalculatorReturningHolidays($year, $existingHolidays);
        $this->givenHolidayHelper();
        $this->whenGetHolidaysForMonthIsCalled($year, $month);
        $this->thenExpectedHolidaysShouldBeReturned($expectedResult);
    }

    private function givenHolidayCalculatorReturningHolidays(int $year, array $existingHolidays): void
    {
        $this->holidayCalculatorMock->calculate(Argument::any(), $year, Argument::any())
            ->willReturn($this->getHolidayList($existingHolidays));
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

    private function whenGetHolidaysForMonthIsCalled(int $year, int $month): void
    {
        $this->actualResult = $this->holidayHelper->getHolidaysForMonth(Germany::class, $year, $month);
    }

    private function thenExpectedHolidaysShouldBeReturned(array $expectedResult): void
    {
        self::assertEquals($this->getHolidayList($expectedResult), $this->actualResult);
    }

    private function thenItShouldReturnAListOfHolidays(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult->getList() as $holiday) {
            $actualResult[] = $holiday->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $actualResult);
    }

    public function getGetHolidaysForMonthData(): array
    {
        return [
            [
                2016,
                2,
                [
                    '2016-01-31',
                    '2016-02-01',
                    '2016-02-15',
                    '2016-02-28',
                    '2016-02-29',
                    '2016-03-01',
                ],
                [
                    '2016-02-01',
                    '2016-02-15',
                    '2016-02-28',
                    '2016-02-29',
                ],
            ],
            [
                2016,
                11,
                [
                    '2016-11-01',
                ],
                [
                    '2016-11-01',
                ],
            ],
            [
                2016,
                11,
                [
                    '2016-10-03',
                ],
                [],
            ],
            [
                2016,
                3,
                [],
                [],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getGetHolidaysByNameData
     */
    public function it_should_calculate_correct_holidays_for_a_holiday_name(int $year, array $existingHolidays, string $holidayName, array $expectedResult): void
    {
        $this->givenHolidayCalculatorReturningHolidays($year, $existingHolidays);
        $this->givenHolidayHelper();
        $this->whenGetHolidaysByNameIsCalled($year, $holidayName);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    private function whenGetHolidaysByNameIsCalled(int $year, string $holidayName): void
    {
        $this->actualResult = $this->holidayHelper->getHolidaysByName(Germany::class, $year, $holidayName);
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

    /**
     * @test
     * @dataProvider getGetNoWorkdaysForTimespanData
     */
    public function it_should_calculate_correct_no_work_days_for_a_timespan(string $firstDay, string $lastDay, array $noWorkWeekdaysProviders, array $expectedResult): void
    {
        $this->givenHolidayCalculator();
        $this->givenHolidayHelper();
        $this->whenGetNoWorkdaysForTimespanIsCalled(new BadenWuerttemberg(), $firstDay, $lastDay, $noWorkWeekdaysProviders);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    private function givenHolidayCalculator(): void
    {
        $this->holidayCalculatorMock = new HolidayCalculator();
    }

    public function getGetNoWorkdaysForTimespanData(): array
    {
        return [
            'sunday-in-short-timespan' => [
                '2016-01-01',
                '2016-01-02',
                [],
                [
                    '2016-01-01',
                ],
            ],
            'sundays-in-same-year' => [
                '2016-01-01',
                '2016-01-11',
                [
                    Sundays::class,
                ],
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-06',
                    '2016-01-10',
                ],
            ],
            'sundays-in-month-with-working-holidays' => [
                '2016-10-01',
                '2016-10-31',
                [],
                [
                    '2016-10-02',
                    '2016-10-03',
                    '2016-10-09',
                    '2016-10-16',
                    '2016-10-23',
                    '2016-10-30',
                ],
            ],
            'sundays-over-two-years' => [
                '2015-12-01',
                '2016-01-02',
                [],
                [
                    '2015-12-06',
                    '2015-12-13',
                    '2015-12-20',
                    '2015-12-25',
                    '2015-12-26',
                    '2015-12-27',
                    '2016-01-01',
                ],
            ],
            'weekends-over-two-years' => [
                '2015-12-01',
                '2016-01-02',
                [
                    Saturdays::class,
                    Sundays::class,
                ],
                [
                    '2015-12-05',
                    '2015-12-06',
                    '2015-12-12',
                    '2015-12-13',
                    '2015-12-19',
                    '2015-12-20',
                    '2015-12-25',
                    '2015-12-26',
                    '2015-12-27',
                    '2016-01-01',
                    '2016-01-02',
                ],
            ],
            'arbitrary-weekdays-over-two-years' => [
                '2015-12-02',
                '2016-01-05',
                [
                    Tuesdays::class,
                    Thursdays::class,
                ],
                [
                    '2015-12-03',
                    '2015-12-08',
                    '2015-12-10',
                    '2015-12-15',
                    '2015-12-17',
                    '2015-12-22',
                    '2015-12-24',
                    '2015-12-25',
                    '2015-12-26',
                    '2015-12-29',
                    '2015-12-31',
                    '2016-01-01',
                    '2016-01-05',
                ],
            ],
            'sundays-over-multiple-years' => [
                '2015-12-01',
                '2017-02-05',
                [],
                [
                    '2015-12-06',
                    '2015-12-13',
                    '2015-12-20',
                    '2015-12-25',
                    '2015-12-26',
                    '2015-12-27',
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-06',
                    '2016-01-10',
                    '2016-01-17',
                    '2016-01-24',
                    '2016-01-31',
                    '2016-02-07',
                    '2016-02-14',
                    '2016-02-21',
                    '2016-02-28',
                    '2016-03-06',
                    '2016-03-13',
                    '2016-03-20',
                    '2016-03-25',
                    '2016-03-27',
                    '2016-03-28',
                    '2016-04-03',
                    '2016-04-10',
                    '2016-04-17',
                    '2016-04-24',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-08',
                    '2016-05-15',
                    '2016-05-16',
                    '2016-05-22',
                    '2016-05-26',
                    '2016-05-29',
                    '2016-06-05',
                    '2016-06-12',
                    '2016-06-19',
                    '2016-06-26',
                    '2016-07-03',
                    '2016-07-10',
                    '2016-07-17',
                    '2016-07-24',
                    '2016-07-31',
                    '2016-08-07',
                    '2016-08-14',
                    '2016-08-21',
                    '2016-08-28',
                    '2016-09-04',
                    '2016-09-11',
                    '2016-09-18',
                    '2016-09-25',
                    '2016-10-02',
                    '2016-10-03',
                    '2016-10-09',
                    '2016-10-16',
                    '2016-10-23',
                    '2016-10-30',
                    '2016-11-01',
                    '2016-11-06',
                    '2016-11-13',
                    '2016-11-20',
                    '2016-11-27',
                    '2016-12-04',
                    '2016-12-11',
                    '2016-12-18',
                    '2016-12-25',
                    '2016-12-26',
                    '2017-01-01',
                    '2017-01-06',
                    '2017-01-08',
                    '2017-01-15',
                    '2017-01-22',
                    '2017-01-29',
                    '2017-02-05',
                ],
            ],
        ];
    }

    private function whenGetNoWorkdaysForTimespanIsCalled(HolidayProviderInterface $holidayProvider, string $firstDay, string $lastDay, array $noWorkWeekdaysProvider): void
    {
        $this->actualResult = $this->holidayHelper->getNoWorkDaysForTimeSpan(
            $holidayProvider,
            new \DateTime($firstDay),
            new \DateTime($lastDay),
            $noWorkWeekdaysProvider
        );
    }

    /**
     * @test
     * @dataProvider getGetHolidayListInICalendarFormatDat
     */
    public function it_should_calculate_correct_icalendar_format_for_holidays(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenHolidayHelper();
        $this->whenGetHolidayListInICalendarFormatIsCalled($holidayList);
        $this->thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat($expectedResult);
    }

    private function whenGetHolidayListInICalendarFormatIsCalled(HolidayList $holidayList): void
    {
        $originalTimeZone = \date_default_timezone_get();
        \date_default_timezone_set('UTC');
        $this->actualResult = $this->holidayHelper->getHolidayListInICalendarFormat($holidayList, new TranslatorStub(), new DateProviderStub(new \DateTime('20160808T120342')));
        \date_default_timezone_set($originalTimeZone);
    }

    private function thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public function getGetHolidayListInICalendarFormatDat(): array
    {
        return [
            [
                new HolidayList(),
                "BEGIN:VCALENDAR\r\n"
                ."VERSION:2.0\r\n"
                ."PRODID:umulmrum/holiday\r\n"
                ."CALSCALE:GREGORIAN\r\n"
                ."END:VCALENDAR\r\n",
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-03-11'),
                ]),
                "BEGIN:VCALENDAR\r\n"
                ."VERSION:2.0\r\n"
                ."PRODID:umulmrum/holiday\r\n"
                ."CALSCALE:GREGORIAN\r\n"
                ."BEGIN:VEVENT\r\n"
                ."UID:name-2016-03-11\r\n"
                ."DTSTAMP:20160808T120342Z+0000\r\n"
                ."CREATED:20160808T120342Z+0000\r\n"
                ."SUMMARY:Very name\r\n"
                ."DTSTART;VALUE=DATE:20160311\r\n"
                ."END:VEVENT\r\n"
                ."END:VCALENDAR\r\n",
            ],
        ];
    }
}
