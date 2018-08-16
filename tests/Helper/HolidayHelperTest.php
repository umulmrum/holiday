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

use DateTime;
use DateTimeZone;
use Prophecy\Prophecy\ObjectProphecy;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Translator\TranslatorInterface;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;

class HolidayHelperTest extends HolidayTestCase
{
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

    /**
     * @test
     * @dataProvider getIsDayAHolidayData
     *
     * @param string $date
     * @param bool   $expectedResult
     */
    public function it_should_tell_if_a_day_is_a_holiday($date, $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenIsDayAHolidayIsCalled(new DateTime($date, $this->getTimezone()));
        $this->thenItShouldTellIdTheDayIsAHoliday($expectedResult);
    }

    private function givenAHolidayHelper()
    {
        $holidayCalculatorMock = $this->prophesize(HolidayCalculatorInterface::class);
        $holidayList1 = new HolidayList();
        $holidayList1->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2016-01-01'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList1->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-01-03')));
        $holidayList1->add(new Holiday(HolidayName::EPIPHANY, new DateTime('2016-01-06'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList1->add(new Holiday(HolidayName::ALL_SAINTS_DAY, new DateTime('2016-11-01'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList2 = new HolidayList();
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-01-10')));
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-01-17')));
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-02-01')));
        $holidayList3 = new HolidayList();
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-11-30')));
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-25'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-26'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList4 = new HolidayList();
        $holidayList4->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-11-29')));
        $holidayList4->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-06')));
        $holidayList4->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-13')));
        $holidayList4->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-20')));
        $holidayList4->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-27')));
        $holidayList5 = new HolidayList();
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-11-28')));
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-12-05')));
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-12-12')));
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-12-19')));
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-12-26'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList6 = new HolidayList();
        $holidayList6->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2017-01-01'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList6->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2017-01-13')));
        $holidayList6->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2017-02-05')));
        $holidayList7 = new HolidayList();
        $holidayList7->add(new Holiday(HolidayName::SUNDAY, new DateTime('2017-01-01'), HolidayType::RELIGIOUS | HolidayType::DAY_OFF));
        $holidayList7->add(new Holiday(HolidayName::SUNDAY, new DateTime('2017-01-08')));
        $holidayList7->add(new Holiday(HolidayName::SUNDAY, new DateTime('2017-01-15')));
        $holidayCalculatorMock->calculateHolidaysForYear(2015, BadenWuerttemberg::ID, $this->getTimezone())->willReturn($holidayList3);
        $holidayCalculatorMock->calculateHolidaysForYear(2015, Saturdays::ID, $this->getTimezone())->willReturn($holidayList5);
        $holidayCalculatorMock->calculateHolidaysForYear(2015, Sundays::ID, $this->getTimezone())->willReturn($holidayList4);
        $holidayCalculatorMock->calculateHolidaysForYear(2016, BadenWuerttemberg::ID, $this->getTimezone())->willReturn($holidayList1);
        $holidayCalculatorMock->calculateHolidaysForYear(2016, Sundays::ID, $this->getTimezone())->willReturn($holidayList2);
        $holidayCalculatorMock->calculateHolidaysForYear(2017, BadenWuerttemberg::ID, $this->getTimezone())->willReturn($holidayList6);
        $holidayCalculatorMock->calculateHolidaysForYear(2017, Sundays::ID, $this->getTimezone())->willReturn($holidayList7);
        $this->holidayHelper = new HolidayHelper($holidayCalculatorMock->reveal());
    }

    /**
     * @param DateTime $date
     */
    private function whenIsDayAHolidayIsCalled($date)
    {
        $this->actualResult = $this->holidayHelper->isDayAHoliday($date, BadenWuerttemberg::ID);
    }

    /**
     * @param bool $expectedResult
     */
    private function thenItShouldTellIdTheDayIsAHoliday($expectedResult)
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    /**
     * @return array
     */
    public function getIsDayAHolidayData()
    {
        return [
            [
                '2016-01-01',
                true,
            ],
            [
                '2016-01-02',
                false,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getGetHolidaysForMonthData
     *
     * @param int   $year
     * @param int   $month
     * @param array $expectedResult
     */
    public function it_should_calculate_a_list_of_all_holidays_in_a_given_month($year, $month, $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetHolidaysForMonthIsCalled($year, $month);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    /**
     * @param int $year
     * @param int $month
     */
    private function whenGetHolidaysForMonthIsCalled($year, $month)
    {
        $this->actualResult = $this->holidayHelper->getHolidaysForMonth($year, $month, BadenWuerttemberg::ID, $this->getTimezone());
    }

    /**
     * @param array $expectedResult
     */
    private function thenItShouldReturnAListOfHolidays($expectedResult)
    {
        $actualResult = [];
        foreach ($this->actualResult->getList() as $holiday) {
            $actualResult[] = $holiday->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function getGetHolidaysForMonthData()
    {
        return [
            [
                2016,
                1,
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-06',
                ],
            ],
            [
                2016,
                11,
                [
                    '2016-11-01',
                ],
            ],
            [
                2016,
                3,
                [],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getGetHolidaysByNameData
     *
     * @param int    $year
     * @param string $holidayName
     * @param array  $expectedResult
     */
    public function it_should_calculate_correct_holidays_for_a_holiday_name($year, $holidayName, array $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetHolidaysByNameIsCalled($year, $holidayName);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    /**
     * @param int    $year
     * @param string $holidayName
     */
    private function whenGetHolidaysByNameIsCalled($year, $holidayName)
    {
        $this->actualResult = $this->holidayHelper->getHolidaysByName($year, $holidayName, BadenWuerttemberg::ID, $this->getTimezone());
    }

    /**
     * @return array
     */
    public function getGetHolidaysByNameData()
    {
        return [
            [
                2016,
                HolidayName::ALL_SAINTS_DAY,
                [
                    '2016-11-01',
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
    public function it_should_calculate_correct_no_work_days_for_a_timespan($firstDay, $lastDay, array $noWorkWeekdaysProviders, array $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetNoWorkdaysForTimespanIsCalled($firstDay, $lastDay, $noWorkWeekdaysProviders);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
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
                    new Sundays(),
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
                    new Saturdays(),
                    new Sundays(),
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
                    '2016-03-27',
                    '2016-04-03',
                    '2016-04-10',
                    '2016-04-17',
                    '2016-04-24',
                    '2016-05-01',
                    '2016-05-08',
                    '2016-05-15',
                    '2016-05-22',
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
                    '2017-01-01',
                    '2017-01-08',
                    '2017-01-15',
                    '2017-01-22',
                    '2017-01-29',
                    '2017-02-05',
                ],
            ],
        ];
    }

    private function whenGetNoWorkdaysForTimespanIsCalled(string $firstDay, string $lastDay, array $noWorkWeekdaysProvider): void
    {
        $this->actualResult = $this->holidayHelper->getNoWorkDaysForTimespan(
            new DateTime($firstDay, $this->getTimezone()),
            new DateTime($lastDay, $this->getTimezone()),
            BadenWuerttemberg::ID,
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
    public function it_should_calculate_correct_icalendar_format_for_holidays(HolidayList $holidayList, $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->givenATranslator();
        $this->whenGetHolidayListInICalendarFormatIsCalled($holidayList);
        $this->thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat($expectedResult);
    }

    private function givenATranslator()
    {
        $this->translator = $this->prophesize(TranslatorInterface::class);
        $this->translator->translateName(new Holiday('name', new DateTime('2016-03-11', $this->getTimezone())))->willReturn('My Holiday');
    }

    /**
     * @param HolidayList $holidayList
     */
    private function whenGetHolidayListInICalendarFormatIsCalled($holidayList)
    {
        $dateHelper = $this->prophesize(DateHelper::class);
        $dateHelper->getCurrentDate(new DateTimeZone('UTC'))->willReturn(new DateTime('20160808T120342', new DateTimeZone('UTC')));
        $this->actualResult = $this->holidayHelper->getHolidayListInICalendarFormat($holidayList, $this->translator->reveal(), $dateHelper->reveal());
    }

    /**
     * @param string $expectedResult
     */
    private function thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat($expectedResult)
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    /**
     * @return array
     */
    public function getGetHolidayListInICalendarFormatDat()
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
                    new Holiday('name', new DateTime('2016-03-11', $this->getTimezone())),
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
