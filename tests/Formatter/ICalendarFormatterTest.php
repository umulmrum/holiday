<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Formatter;

use umulmrum\Holiday\Formatter\ICalendarFormatter;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Test\DateProviderStub;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Test\TranslatorStub;

final class ICalendarFormatterTest extends HolidayTestCase
{
    /**
     * @var ICalendarFormatter
     */
    private $subject;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getFormatData
     */
    public function it_should_format_single_values(Holiday $holiday, string $expectedResult): void
    {
        $this->givenICalendarFormatter();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public function getFormatData(): array
    {
        return [
            [
                Holiday::create('name', '2016-03-11'),
                "BEGIN:VEVENT\r\n"
                ."UID:name-2016-03-11\r\n"
                ."DTSTAMP:20160808T120342Z+0000\r\n"
                ."CREATED:20160808T120342Z+0000\r\n"
                ."SUMMARY:Very name\r\n"
                ."DTSTART;VALUE=DATE:20160311\r\n"
                .'END:VEVENT',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatListData
     */
    public function it_should_format_list_values(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenICalendarFormatter();
        $this->whenFormatListIsCalled($holidayList);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public function getFormatListData(): array
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

    private function givenICalendarFormatter(): void
    {
        $this->subject = new ICalendarFormatter(new TranslatorStub(), new DateProviderStub(new \DateTime('20160808T120342')));
    }

    private function whenFormatIsCalled(Holiday $holiday): void
    {
        $this->actualResult = $this->subject->format($holiday);
    }

    private function whenFormatListIsCalled(HolidayList $holidayList): void
    {
        $originalTimeZone = \date_default_timezone_get();
        \date_default_timezone_set('UTC');
        $this->actualResult = $this->subject->formatList($holidayList);
        \date_default_timezone_set($originalTimeZone);
    }

    private function thenAFormattedResultShouldBeReturned(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }
}
