<?php

namespace umulmrum\Holiday\Helper;

use DateTime;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Weekday\WeekdayInitializer;
use umulmrum\Holiday\Provider\Weekday\Weekdays;

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
     * @param string                   $date
     * @param bool                     $expectedResult
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
        $holidayCalculatorMock->calculateHolidaysForYear(2016, new BadenWuerttemberg(), $this->getTimezone())->willReturn($holidayList1);
        $holidayCalculatorMock->calculateHolidaysForYear(2016, new Weekdays(Weekday::SUNDAY), $this->getTimezone())->willReturn($holidayList2);
        $this->holidayHelper = new HolidayHelper($holidayCalculatorMock->reveal());
    }

    /**
     * @param DateTime                 $date
     */
    private function whenIsDayAHolidayIsCalled($date)
    {
        $this->actualResult = $this->holidayHelper->isDayAHoliday($date, new BadenWuerttemberg());
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
     * @param int                      $year
     * @param int                      $month
     * @param array                    $expectedResult
     */
    public function it_should_calculate_a_list_of_all_holidays_in_a_given_month($year, $month, $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetHolidaysForMonthIsCalled($year, $month);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    /**
     * @param int                      $year
     * @param int                      $month
     */
    private function whenGetHolidaysForMonthIsCalled($year, $month)
    {
        $this->actualResult = $this->holidayHelper->getHolidaysForMonth($year, $month, new BadenWuerttemberg(), $this->getTimezone());
    }

    /**
     * @param array $expectedResult
     */
    private function thenItShouldReturnAListOfHolidays($expectedResult)
    {
        $actualResult = [];
        foreach ($this->actualResult->getFlatArray() as $holiday) {
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
     * @param int                      $year
     * @param string                   $holidayName
     * @param array                    $expectedResult
     */
    public function it_should_calculate_correct_holidays_for_a_holiday_name($year, $holidayName, array $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetHolidaysByNameIsCalled($year, $holidayName);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    /**
     * @param int                      $year
     * @param string                   $holidayName
     */
    private function whenGetHolidaysByNameIsCalled($year, $holidayName)
    {
        $this->actualResult = $this->holidayHelper->getHolidaysByName($year, $holidayName, new BadenWuerttemberg(), $this->getTimezone());
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
     * @param string                   $firstDay
     * @param string                   $lastDay
     * @param array                    $expectedResult
     */
    public function it_should_calculate_correct_no_work_days_for_a_timespan($firstDay, $lastDay, array $expectedResult)
    {
        $this->givenAHolidayHelper();
        $this->whenGetNoWorkdaysForTimespanIsCalled($firstDay, $lastDay);
        $this->thenItShouldReturnAListOfHolidays($expectedResult);
    }

    /**
     * @param string $firstDay
     * @param string $lastDay
     */
    private function whenGetNoWorkdaysForTimespanIsCalled($firstDay, $lastDay)
    {
        $this->actualResult = $this->holidayHelper->getNoWorkDaysForTimespan(
            new DateTime($firstDay, $this->getTimezone()),
            new DateTime($lastDay, $this->getTimezone()),
            new BadenWuerttemberg()
        );
    }

    public function getGetNoWorkdaysForTimespanData()
    {
        return [
            [
                '2016-01-01',
                '2016-01-02',
                [
                    '2016-01-01',
                ],
            ],
            [
                '2016-01-01',
                '2016-01-11',
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-05',
                    '2016-01-10',
                ],
            ],
        ];
    }
}
