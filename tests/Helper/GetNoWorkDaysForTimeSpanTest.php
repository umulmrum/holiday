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

use umulmrum\Holiday\Helper\GetNoWorkDaysForTimeSpan;
use umulmrum\Holiday\HolidayCalculator;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Provider\Weekday\Thursdays;
use umulmrum\Holiday\Provider\Weekday\Tuesdays;
use umulmrum\Holiday\Test\HolidayTestCase;

final class GetNoWorkDaysForTimeSpanTest extends HolidayTestCase
{
    /**
     * @var GetNoWorkDaysForTimeSpan
     */
    private $subject;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getGetNoWorkdaysForTimespanData
     */
    public function it_should_calculate_correct_no_work_days_for_a_timespan(string $firstDay, string $lastDay, array $noWorkWeekdaysProviders, array $expectedResult): void
    {
        $this->givenGetNoWorkDaysForTimeSpan();
        $this->whenGetNoWorkdaysForTimespanIsCalled(new BadenWuerttemberg(), $firstDay, $lastDay, $noWorkWeekdaysProviders);
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

    private function givenGetNoWorkDaysForTimeSpan(): void
    {
        $this->subject = new GetNoWorkDaysForTimeSpan(new HolidayCalculator());
    }

    private function whenGetNoWorkdaysForTimespanIsCalled(HolidayProviderInterface $holidayProvider, string $firstDay, string $lastDay, array $noWorkWeekdaysProvider): void
    {
        $this->actualResult = ($this->subject)(
            $holidayProvider,
            new \DateTime($firstDay),
            new \DateTime($lastDay),
            $noWorkWeekdaysProvider
        );
    }

    private function thenItShouldReturnAListOfHolidays(array $expectedResult): void
    {
        $actualResult = [];
        foreach ($this->actualResult->getList() as $holiday) {
            $actualResult[] = $holiday->getFormattedDate('Y-m-d');
        }
        self::assertEquals($expectedResult, $actualResult);
    }
}
