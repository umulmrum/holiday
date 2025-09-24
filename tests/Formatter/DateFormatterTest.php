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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Formatter\DateFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class DateFormatterTest extends HolidayTestCase
{
    private DateFormatter $formatter;

    /**
     * @var string|string[]
     */
    private array|string $actualResult;

    #[DataProvider('getFormatData')]
    #[Test]
    public function itShouldFormatSingleValues(string $date, string $format, string $expectedResult): void
    {
        $this->givenAFormatter($format);
        $this->whenFormatIsCalled($date);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                '2016-01-01',
                'Y-m-d',
                '2016-01-01',
            ],
            [
                '2016-01-01',
                'Y-m-d',
                '2016-01-01',
            ],
            [
                '2016-01-01',
                Holiday::DISPLAY_DATE_FORMAT,
                '2016-01-01',
            ],
            [
                '2016-01-01',
                Holiday::DISPLAY_DATE_FORMAT,
                '2016-01-01',
            ],
            [
                '2016-01-01',
                'm',
                '01',
            ],
        ];
    }

    private function givenAFormatter(string $format): void
    {
        $this->formatter = new DateFormatter($format);
    }

    private function whenFormatIsCalled(string $dateString): void
    {
        $holiday = Holiday::create('name', $dateString);
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    /**
     * @param string[]        $dates
     * @param string|string[] $expectedResult
     */
    #[DataProvider('getFormatListData')]
    #[Test]
    public function itShouldFormatListValues(array $dates, string $format, $expectedResult): void
    {
        $this->givenAFormatter($format);
        $this->whenFormatListIsCalled($dates);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                [
                    '2016-01-01',
                ],
                'Y-m-d',
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                ],
                Holiday::DISPLAY_DATE_FORMAT,
                [
                    '2016-01-01',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2013-12-24',
                ],
                'm',
                [
                    '01',
                    '12',
                ],
            ],
            [
                [
                    '2016-01-01',
                    '2015-12-24',
                    '2014-12-24',
                    '2013-12-24',
                    '2012-12-24',
                ],
                'Y',
                [
                    '2016',
                    '2015',
                    '2014',
                    '2013',
                    '2012',
                ],
            ],
        ];
    }

    /**
     * @param string[] $dates
     */
    private function whenFormatListIsCalled(array $dates): void
    {
        $holidayList = new HolidayList();
        foreach ($dates as $date) {
            $holidayList->add(Holiday::create('name', $date));
        }
        $this->actualResult = $this->formatter->formatList($holidayList);
    }
}
