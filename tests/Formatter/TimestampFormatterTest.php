<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class TimestampFormatterTest extends HolidayTestCase
{
    /**
     * @var TimestampFormatter
     */
    private $formatter;
    /**
     * @var string|string[]
     */
    private $actualResult;

    private $originalTimeZone;

    protected function tearDown(): void
    {
        parent::tearDown();
        date_default_timezone_set($this->originalTimeZone);
    }

    /**
     * @test
     * @dataProvider getFormatData
     */
    public function it_should_format_single_values(string $date, string $timeZone, string $expectedResult): void
    {
        $this->givenTimeZone($timeZone);
        $this->givenAFormatter();
        $this->whenFormatIsCalled($date);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenTimeZone(string $timeZone): void
    {
        $this->originalTimeZone = date_default_timezone_get();
        date_default_timezone_set($timeZone);
    }

    private function givenAFormatter()
    {
        $this->formatter = new TimestampFormatter();
    }

    /**
     * @param string $date
     */
    private function whenFormatIsCalled($date)
    {
        $holiday = Holiday::create('name', $date);
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult)
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public function getFormatData(): array
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

    /**
     * @test
     * @dataProvider getFormatListData
     *
     * @param string[] $dates
     * @param string[] $expectedResult
     */
    public function it_should_format_list_values(array $dates, string $timeZone, array $expectedResult)
    {
        $this->givenTimeZone($timeZone);
        $this->givenAFormatter();
        $this->whenFormatListIsCalled($dates);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[] $dates
     */
    private function whenFormatListIsCalled(array $dates)
    {
        $holidayList = new HolidayList();
        foreach ($dates as $date) {
            $holidayList->add(new Holiday('name', new \DateTime($date)));
        }
        $this->actualResult = $this->formatter->formatList($holidayList);
    }

    public function getFormatListData(): array
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
}
