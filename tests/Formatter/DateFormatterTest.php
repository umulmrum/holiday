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

use DateTime;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class DateFormatterTest extends HolidayTestCase
{
    /**
     * @var DateFormatter
     */
    private $formatter;
    /**
     * @var int|string|int[]|string[]
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getFormatData
     *
     * @param string|null $defaultFormat
     * @param string      $date
     * @param string|null $format
     * @param int|string  $expectedResult
     */
    public function it_should_format_single_values($defaultFormat, $date, $format, $expectedResult)
    {
        $this->givenAFormatter($defaultFormat);
        $this->whenFormatIsCalled($date, $format);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string|null $defaultFormat
     */
    private function givenAFormatter($defaultFormat = null)
    {
        if (null === $defaultFormat) {
            $this->formatter = new DateFormatter();
        } else {
            $this->formatter = new DateFormatter($defaultFormat);
        }
    }

    /**
     * @param string      $dateString
     * @param string|null $format
     */
    private function whenFormatIsCalled($dateString, $format)
    {
        $holiday = new Holiday('name', new DateTime($dateString));
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
     * @param int|string|int[]|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult)
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    /**
     * @return array
     */
    public function getFormatData()
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
     * @param string|null               $defaultFormat
     * @param string[]                  $dates
     * @param string|null               $format
     * @param int|string|int[]|string[] $expectedResult
     */
    public function it_should_format_list_values($defaultFormat, $dates, $format, $expectedResult)
    {
        $this->givenAFormatter($defaultFormat);
        $this->whenFormatListIsCalled($dates, $format);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[]    $dates
     * @param string|null $format
     */
    private function whenFormatListIsCalled(array $dates, $format)
    {
        $holidayList = new HolidayList();
        foreach ($dates as $date) {
            $holidayList->add(new Holiday('name', new DateTime($date)));
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

    /**
     * @return array
     */
    public function getFormatListData()
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
