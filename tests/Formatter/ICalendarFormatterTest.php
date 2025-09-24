<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Formatter;

use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Formatter\ICalendarFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\DateProviderStub;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;

use function date_default_timezone_get;
use function date_default_timezone_set;

final class ICalendarFormatterTest extends HolidayTestCase
{
    private ICalendarFormatter $subject;

    /**
     * @var string|string[]
     */
    private array|string $actualResult;

    #[DataProvider('getFormatData')]
    #[Test]
    public function itShouldFormatSingleValues(Holiday $holiday, string $expectedResult): void
    {
        $this->givenICalendarFormatter();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                Holiday::create('name', '2016-03-11'),
                "BEGIN:VEVENT\r\n"
                . "UID:name-2016-03-11\r\n"
                . "DTSTAMP:20160808T120342Z+0000\r\n"
                . "CREATED:20160808T120342Z+0000\r\n"
                . "SUMMARY:Very name\r\n"
                . "DTSTART;VALUE=DATE:20160311\r\n"
                . 'END:VEVENT',
            ],
        ];
    }

    #[DataProvider('getFormatListData')]
    #[Test]
    public function itShouldFormatListValues(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenICalendarFormatter();
        $this->whenFormatListIsCalled($holidayList);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                new HolidayList(),
                "BEGIN:VCALENDAR\r\n"
                . "VERSION:2.0\r\n"
                . "PRODID:umulmrum/holiday\r\n"
                . "CALSCALE:GREGORIAN\r\n"
                . "END:VCALENDAR\r\n",
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-03-11'),
                ]),
                "BEGIN:VCALENDAR\r\n"
                . "VERSION:2.0\r\n"
                . "PRODID:umulmrum/holiday\r\n"
                . "CALSCALE:GREGORIAN\r\n"
                . "BEGIN:VEVENT\r\n"
                . "UID:name-2016-03-11\r\n"
                . "DTSTAMP:20160808T120342Z+0000\r\n"
                . "CREATED:20160808T120342Z+0000\r\n"
                . "SUMMARY:Very name\r\n"
                . "DTSTART;VALUE=DATE:20160311\r\n"
                . "END:VEVENT\r\n"
                . "END:VCALENDAR\r\n",
            ],
        ];
    }

    #[Test]
    public function itShouldUseDefaultsIfNoConstructorArguments(): void
    {
        $this->givenICalendarFormatterWithoutArguments();
        $this->whenFormatIsCalled(Holiday::create('name', '2020-01-01'));
        $this->thenOutputShouldDependOnDefaults();
    }

    private function givenICalendarFormatter(): void
    {
        $this->subject = new ICalendarFormatter(new TranslatorStub(), new DateProviderStub(new DateTime('20160808T120342')));
    }

    private function givenICalendarFormatterWithoutArguments(): void
    {
        $this->subject = new ICalendarFormatter();
    }

    private function whenFormatIsCalled(Holiday $holiday): void
    {
        $this->actualResult = $this->subject->format($holiday);
    }

    private function whenFormatListIsCalled(HolidayList $holidayList): void
    {
        $originalTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $this->actualResult = $this->subject->formatList($holidayList);
        date_default_timezone_set($originalTimeZone);
    }

    private function thenAFormattedResultShouldBeReturned(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    private function thenOutputShouldDependOnDefaults(): void
    {
        /*
         * Don't use minutes and seconds to minimize test brittleness - we just assume that the correct time is printed
         * if the rest of the date is current. We already tested correctness of date formatting above.
         */
        $now = (new DateTime('now'))->format('Ymd\TH');

        /** @var string $actualResult */
        $actualResult = $this->actualResult;
        self::assertStringContainsString('DTSTAMP:' . $now, $actualResult);
        self::assertStringContainsString('CREATED:' . $now, $actualResult);
        self::assertStringContainsString('SUMMARY:name', $actualResult);
    }
}
