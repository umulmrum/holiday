<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Helper;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Germany\Germany;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Provider\Weekday\Thursdays;
use umulmrum\Holiday\Provider\Weekday\Tuesdays;
use umulmrum\Holiday\Translator\TranslatorInterface;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;

class HolidayHelperTest extends HolidayTestCase
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
    /**
     * @var TranslatorInterface|ObjectProphecy
     */
    private $translator;

    protected function setUp()
    {
        parent::setUp();
        $this->holidayCalculatorMock = $this->prophesize(HolidayCalculatorInterface::class);
    }

    /**
     * @test
     */
    public function it_should_tell_if_a_day_is_a_holiday(): void
    {
        $this->givenHolidayCalculatorReturningNewYear();
        $this->givenHolidayHelper();

        $this->whenIsDayAHolidayIsCalledForNewYear();
        $this->thenTheDayShouldBeRecognizedAsHoliday();

        $this->whenIsDayAHolidayIsCalledForARegularDay();
        $this->thenTheDayShouldNotBeRecognizedAsHoliday();
    }

    private function givenHolidayCalculatorReturningNewYear(): void
    {
        $this->holidayCalculatorMock->calculateHolidaysForYear(Argument::any(), 2016, Argument::any())->willReturn(new HolidayList([
            new Holiday(HolidayName::NEW_YEAR, new \DateTime('2016-01-01')),
        ]));
    }

    private function givenHolidayHelper(): void
    {
        if ($this->holidayCalculatorMock instanceof ObjectProphecy) {
            $this->holidayHelper = new HolidayHelper($this->holidayCalculatorMock->reveal());
        } else {
            $this->holidayHelper = new HolidayHelper($this->holidayCalculatorMock);
        }
    }

    private function whenIsDayAHolidayIsCalledForNewYear(): void
    {
        $this->actualResult = $this->holidayHelper->isDayAHoliday(Argument::any(), new \DateTime('2016-01-01', $this->getTimezone()));
    }

    private function thenTheDayShouldBeRecognizedAsHoliday(): void
    {
        $this->assertTrue($this->actualResult);
    }

    private function whenIsDayAHolidayIsCalledForARegularDay(): void
    {
        $this->actualResult = $this->holidayHelper->isDayAHoliday(Argument::any(), new \DateTime('2016-05-23', $this->getTimezone()));
    }

    private function thenTheDayShouldNotBeRecognizedAsHoliday(): void
    {
        $this->assertFalse($this->actualResult);
    }

    /**
     * @test
     * @dataProvider getGetHolidaysForMonthData
     *
     * @param int   $year
     * @param int   $month
     * @param array $existingHolidays
     * @param array $expectedResult
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
        $this->holidayCalculatorMock->calculateHolidaysForYear(Argument::any(), $year, Argument::any())
            ->willReturn($this->getHolidayList($existingHolidays));
    }

    private function getHolidayList(array $data): HolidayList
    {
        $holidayList = new HolidayList();
        foreach ($data as $element) {
            if (true === \is_string($element)) {
                $holidayList->add(new Holiday('foo', new \DateTime($element, $this->getTimezone())));
            } else {
                $holidayList->add($element);
            }
        }

        return $holidayList;
    }

    private function whenGetHolidaysForMonthIsCalled(int $year, int $month): void
    {
        $this->actualResult = $this->holidayHelper->getHolidaysForMonth(Germany::class, $year, $month, $this->getTimezone());
    }

    private function thenExpectedHolidaysShouldBeReturned(array $expectedResult): void
    {
        $this->assertEquals($this->getHolidayList($expectedResult), $this->actualResult);
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
     *
     * @param int    $year
     * @param array  $existingHolidays
     * @param string $holidayName
     * @param array  $expectedResult
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
        $this->actualResult = $this->holidayHelper->getHolidaysByName(Germany::class, $year, $holidayName, $this->getTimezone());
    }

    public function getGetHolidaysByNameData(): array
    {
        return [
            [
                2016,
                [
                    new Holiday(HolidayName::NEW_YEAR, new \DateTime('2016-01-01', $this->getTimezone())),
                    new Holiday(HolidayName::ALL_SAINTS_DAY, new \DateTime('2016-11-01', $this->getTimezone())),
                    new Holiday(HolidayName::CHRISTMAS_DAY, new \DateTime('2016-12-25', $this->getTimezone())),
                ],
                HolidayName::ALL_SAINTS_DAY,
                [
                    '2016-11-01',
                ],
            ],
            [
                2016,
                [
                    new Holiday(HolidayName::NEW_YEAR, new \DateTime('2016-01-01', $this->getTimezone())),
                    new Holiday(HolidayName::ALL_SAINTS_DAY, new \DateTime('2016-11-01', $this->getTimezone())),
                    new Holiday(HolidayName::CHRISTMAS_DAY, new \DateTime('2016-12-25', $this->getTimezone())),
                ],
                HolidayName::LABOR_DAY,
                [],
            ],
            [
                2016,
                [
                    new Holiday(HolidayName::NEW_YEAR, new \DateTime('2016-01-01', $this->getTimezone())),
                    new Holiday(HolidayName::SUNDAY, new \DateTime('2016-11-06', $this->getTimezone())),
                    new Holiday(HolidayName::SUNDAY, new \DateTime('2016-11-13', $this->getTimezone())),
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
     *
     * @param string $firstDay
     * @param string $lastDay
     * @param array  $noWorkWeekdaysProviders
     * @param array  $expectedResult
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
            new \DateTime($firstDay, $this->getTimezone()),
            new \DateTime($lastDay, $this->getTimezone()),
            $noWorkWeekdaysProvider
        );
    }

    /**
     * @test
     * @dataProvider getGetHolidayListInICalendarFormatDat
     *
     * @param HolidayList $holidayList
     * @param string      $expectedResult
     */
    public function it_should_calculate_correct_icalendar_format_for_holidays(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenHolidayHelper();
        $this->givenATranslator();
        $this->whenGetHolidayListInICalendarFormatIsCalled($holidayList);
        $this->thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat($expectedResult);
    }

    private function givenATranslator(): void
    {
        $this->translator = $this->prophesize(TranslatorInterface::class);
        $this->translator->translateName(new Holiday('name', new \DateTime('2016-03-11', $this->getTimezone())))->willReturn('My Holiday');
    }

    private function whenGetHolidayListInICalendarFormatIsCalled(HolidayList $holidayList): void
    {
        $dateHelper = $this->prophesize(DateHelper::class);
        $dateHelper->getCurrentDate(new \DateTimeZone('UTC'))->willReturn(new \DateTime('20160808T120342', new \DateTimeZone('UTC')));
        $this->actualResult = $this->holidayHelper->getHolidayListInICalendarFormat($holidayList, $this->translator->reveal(), $dateHelper->reveal());
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
                    new Holiday('name', new \DateTime('2016-03-11', $this->getTimezone())),
                ]),
                "BEGIN:VCALENDAR\r\n"
                ."VERSION:2.0\r\n"
                ."PRODID:umulmrum/holiday\r\n"
                ."CALSCALE:GREGORIAN\r\n"
                ."BEGIN:VEVENT\r\n"
                ."UID:name-2016-03-11\r\n"
                ."DTSTAMP:20160808T120342Z+0000\r\n"
                ."CREATED:20160808T120342Z+0000\r\n"
                ."SUMMARY:My Holiday\r\n"
                ."DTSTART;VALUE=DATE:20160311\r\n"
                ."END:VEVENT\r\n"
                ."END:VCALENDAR\r\n",
            ],
        ];
    }
}
