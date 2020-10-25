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

use umulmrum\Holiday\Helper\GetHolidayListInICalendarFormat;
use umulmrum\Holiday\Test\DateProviderStub;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Test\TranslatorStub;

final class GetHolidayListInICalendarFormatTest extends HolidayTestCase
{
    /**
     * @var GetHolidayListInICalendarFormat
     */
    private $subject;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getGetHolidayListInICalendarFormatDat
     */
    public function it_should_calculate_correct_icalendar_format_for_holidays(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenGetHolidayListInICalendarFormat();
        $this->whenGetHolidayListInICalendarFormatIsCalled($holidayList);
        $this->thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat($expectedResult);
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

    private function givenGetHolidayListInICalendarFormat(): void
    {
        $this->subject = new GetHolidayListInICalendarFormat();
    }

    private function whenGetHolidayListInICalendarFormatIsCalled(HolidayList $holidayList): void
    {
        $originalTimeZone = \date_default_timezone_get();
        \date_default_timezone_set('UTC');
        $this->actualResult = ($this->subject)($holidayList, new TranslatorStub(), new DateProviderStub(new \DateTime('20160808T120342')));
        \date_default_timezone_set($originalTimeZone);
    }

    private function thenItShouldReturnAFormattedListOfHolidaysInICalendarFormat(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }
}
