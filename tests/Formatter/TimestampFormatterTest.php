<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Formatter;

use DateTime;
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
     * @var int|int[]
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getFormatData
     *
     * @param string $date
     * @param int    $expectedResult
     */
    public function it_should_format_single_values($date, $expectedResult)
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($date);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
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
        $holiday = new Holiday('name', new DateTime($date));
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param int|int[] $expectedResult
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
                '2016-01-01',
                1451606400,
            ],
            [
                '1970-01-01',
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatListData
     *
     * @param string[] $dates
     * @param int[]    $expectedResult
     */
    public function it_should_format_list_values($dates, $expectedResult)
    {
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
            $holidayList->add(new Holiday('name', new DateTime($date)));
        }
        $this->actualResult = $this->formatter->formatList($holidayList);
    }

    /**
     * @return array
     */
    public function getFormatListData()
    {
        return [
            [
                [],
                [],
            ],
            [
                [
                    '2016-01-01',
                ],
                [
                    1451606400,
                ],
            ],
            [
                [
                    '2016-01-01',
                    '1970-01-01',
                ],
                [
                    1451606400,
                    0,
                ],
            ],
        ];
    }
}
