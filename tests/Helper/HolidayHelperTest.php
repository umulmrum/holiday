<?php

namespace umulmrum\Holiday\Helper;

use DateTime;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;

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
        $holidayCalculatorMock = $this->prophesize('\umulmrum\Holiday\Calculator\HolidayCalculatorInterface');
        $holidayList1 = new HolidayList();
        $holidayList1->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2016-01-01')));
        $holidayList1->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2016-01-03')));
        $holidayList1->add(new Holiday(HolidayName::NEW_YEAR, new DateTime('2016-01-05')));
        $holidayList1->add(new Holiday(HolidayName::ALL_SAINTS_DAY, new DateTime('2016-11-01')));
        $holidayList2 = new HolidayList();
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-01-10')));
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-01-17')));
        $holidayList2->add(new Holiday(HolidayName::SUNDAY, new DateTime('2016-02-01')));
        $holidayList3 = new HolidayList();
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-11-30')));
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-25')));
        $holidayList3->add(new Holiday(HolidayName::SUNDAY, new DateTime('2015-12-26')));
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
        $holidayList5->add(new Holiday(HolidayName::SATURDAY, new DateTime('2015-12-26')));
        $holidayCalculatorMock->calculateHolidaysForYear(2015, BadenWuerttemberg::ID, $this->getTimezone())->willReturn($holidayList3);
        $holidayCalculatorMock->calculateHolidaysForYear(2015, Saturdays::ID, $this->getTimezone())->willReturn($holidayList5);
        $holidayCalculatorMock->calculateHolidaysForYear(2015, Sundays::ID, $this->getTimezone())->willReturn($holidayList4);
        $holidayCalculatorMock->calculateHolidaysForYear(2016, BadenWuerttemberg::ID, $this->getTimezone())->willReturn($holidayList1);
        $holidayCalculatorMock->calculateHolidaysForYear(2016, Sundays::ID, $this->getTimezone())->willReturn($holidayList2);
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
                    '2016-01-05',
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

    /**
     * @param string $firstDay
     * @param string $lastDay
     * @param array  $noWorkWeekdaysProvider
     */
    private function whenGetNoWorkdaysForTimespanIsCalled($firstDay, $lastDay, array $noWorkWeekdaysProvider)
    {
        $this->actualResult = $this->holidayHelper->getNoWorkDaysForTimespan(
            new DateTime($firstDay, $this->getTimezone()),
            new DateTime($lastDay, $this->getTimezone()),
            BadenWuerttemberg::ID,
            $noWorkWeekdaysProvider
        );
    }

    public function getGetNoWorkdaysForTimespanData()
    {
        return [
            [
                '2016-01-01',
                '2016-01-02',
                [],
                [
                    '2016-01-01',
                ],
            ],
            [
                '2016-01-01',
                '2016-01-11',
                [
                    new Sundays(),
                ],
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-05',
                    '2016-01-10',
                ],
            ],
            [
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
            [
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
            [
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
        ];
    }
}
