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

use Umulmrum\Holiday\Formatter\DateFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class DateFormatterTest extends HolidayTestCase
{
    /**
     * @var DateFormatter
     */
    private $formatter;
    /**
     * @var string|string[]
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getFormatData
     *
     * @param int|string $expectedResult
     */
    public function it_should_format_single_values(?string $defaultFormat, string $date, ?string $format, string $expectedResult): void
    {
        $this->givenAFormatter($defaultFormat);
        $this->whenFormatIsCalled($date, $format);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatter(?string $defaultFormat = null): void
    {
        if (null === $defaultFormat) {
            $this->formatter = new DateFormatter();
        } else {
            $this->formatter = new DateFormatter($defaultFormat);
        }
    }

    private function whenFormatIsCalled(string $dateString, ?string $format): void
    {
        $holiday = Holiday::create('name', $dateString);
        if (null === $format) {
            $this->actualResult = $this->formatter->format($holiday);
        } else {
            $options = [
                DateFormatter::PARAM_FORMAT => $format,
            ];
            $this->actualResult = $this->formatter->format($holiday, $options);
        }
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public function getFormatData(): array
    {
        return [
            [
                null,
                '2016-01-01',
                'Y-m-d',
                '2016-01-01',
            ],
            [
                'm',
                '2016-01-01',
                'Y-m-d',
                '2016-01-01',
            ],
            [
                'Y-m-d',
                '2016-01-01',
                null,
                '2016-01-01',
            ],
            [
                null,
                '2016-01-01',
                null,
                '2016-01-01',
            ],
            [
                'Y-m-d',
                '2016-01-01',
                'm',
                '01',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatListData
     *
     * @param string[]        $dates
     * @param string|string[] $expectedResult
     */
    public function it_should_format_list_values(?string $defaultFormat, array $dates, ?string $format, $expectedResult): void
    {
        $this->givenAFormatter($defaultFormat);
        $this->whenFormatListIsCalled($dates, $format);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[] $dates
     */
    private function whenFormatListIsCalled(array $dates, ?string $format): void
    {
        $holidayList = new HolidayList();
        foreach ($dates as $date) {
            $holidayList->add(Holiday::create('name', $date));
        }
        if (null === $format) {
            $this->actualResult = $this->formatter->formatList($holidayList);
        } else {
            $options = [
                DateFormatter::PARAM_FORMAT => $format,
            ];
            $this->actualResult = $this->formatter->formatList($holidayList, $options);
        }
    }

    public function getFormatListData(): array
    {
        return [
            [
                null,
                [
                    '2016-01-01',
                ],
                'Y-m-d',
                [
                    '2016-01-01',
                ],
            ],
            [
                'Y-m-d',
                [
                    '2016-01-01',
                ],
                null,
                [
                    '2016-01-01',
                ],
            ],
            [
                null,
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
                null,
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
}
