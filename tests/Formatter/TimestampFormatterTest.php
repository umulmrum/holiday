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
use Umulmrum\Holiday\Formatter\TimestampFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class TimestampFormatterTest extends HolidayTestCase
{
    private TimestampFormatter $formatter;

    /**
     * @var string|string[]
     */
    private array|string $actualResult;
    private string $originalTimeZone;

    protected function tearDown(): void
    {
        parent::tearDown();
        date_default_timezone_set($this->originalTimeZone);
    }

    #[DataProvider('getFormatData')]
    #[Test]
    public function itShouldFormatSingleValues(string $date, string $timeZone, string $expectedResult): void
    {
        $this->givenTimeZone($timeZone);
        $this->givenAFormatter();
        $this->whenFormatIsCalled($date);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                '2016-01-01',
                'UTC',
                '1451606400',
            ],
            [
                '2016-01-01',
                'Europe/Berlin',
                '1451602800',
            ],
            [
                '1970-01-01',
                'UTC',
                '0',
            ],
            [
                '1970-01-01',
                'Europe/Berlin',
                '-3600',
            ],
        ];
    }

    private function givenTimeZone(string $timeZone): void
    {
        $this->originalTimeZone = date_default_timezone_get();
        date_default_timezone_set($timeZone);
    }

    private function givenAFormatter(): void
    {
        $this->formatter = new TimestampFormatter();
    }

    private function whenFormatIsCalled(string $date): void
    {
        $holiday = Holiday::create('name', $date);
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
     * @param string[] $dates
     * @param string[] $expectedResult
     */
    #[DataProvider('getFormatListData')]
    #[Test]
    public function itShouldFormatListValues(array $dates, string $timeZone, array $expectedResult): void
    {
        $this->givenTimeZone($timeZone);
        $this->givenAFormatter();
        $this->whenFormatListIsCalled($dates);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                [],
                'UTC',
                [],
            ],
            [
                [
                    '2016-01-01',
                ],
                'UTC',
                [
                    1451606400,
                ],
            ],
            [
                [
                    '2016-01-01',
                    '1970-01-01',
                ],
                'UTC',
                [
                    1451606400,
                    0,
                ],
            ],
            [
                [
                    '2016-01-01',
                    '1970-01-01',
                ],
                'Europe/Berlin',
                [
                    1451602800,
                    -3600,
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
