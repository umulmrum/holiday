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
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class JsonFormatterTest extends HolidayTestCase
{
    /**
     * @var JsonFormatter
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
     * @param Holiday    $holiday
     * @param int|string $expectedResult
     */
    public function it_should_format_single_values(Holiday $holiday, $expectedResult)
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatter()
    {
        $this->formatter = new JsonFormatter();
    }

    /**
     * @param Holiday $holiday
     */
    private function whenFormatIsCalled(Holiday $holiday)
    {
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult)
    {
        self::assertJsonStringEqualsJsonString($expectedResult, $this->actualResult);
    }

    /**
     * @return array
     */
    public function getFormatData()
    {
        return [
            [
                new Holiday('name', new DateTime('2016-03-17', $this->getTimezone()), HolidayType::OTHER),
                '{
                    "name": "name",
                    "translatedName": "name",
                    "timestamp": 1458172800,
                    "formattedDate": "20160317T000000Z+0000",
                    "type": 0,
                    "formattedType": [
                        "other"
                    ]
                }',
            ],
            [
                new Holiday('name', new DateTime('2016-03-17', $this->getTimezone()), HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
                '{
                    "name": "name",
                    "translatedName": "name",
                    "timestamp": 1458172800,
                    "formattedDate": "20160317T000000Z+0000",
                    "type": 6,
                    "formattedType": [
                        "day_off",
                        "religious"
                    ]
                }',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatTranslatedData
     *
     * @param Holiday $holiday
     * @param string $expectedResult
     */
    public function it_should_format_single_values_with_translation(Holiday $holiday, $expectedResult)
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatterWithTranslator()
    {
        $translator = $this->prophesize('\umulmrum\Holiday\Translator\TranslatorInterface');
        $translator->translateName(new Holiday('name', new DateTime('2016-03-17', $this->getTimezone()), 6))->willReturn('Very name');
        $translator->translate('day_off')->willReturn('Day off');
        $translator->translate('religious')->willReturn('Religious');
        $this->formatter = new JsonFormatter($translator->reveal());
    }

    /**
     * @return array
     */
    public function getFormatTranslatedData()
    {
        return [
            [
                new Holiday('name', new DateTime('2016-03-17', $this->getTimezone()), HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
                '{
                    "name": "name",
                    "translatedName": "Very name",
                    "timestamp": 1458172800,
                    "formattedDate": "20160317T000000Z+0000",
                    "type": 6,
                    "formattedType": [
                        "Day off",
                        "Religious"
                    ]
                }',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatListData
     *
     * @param HolidayList $holidayList
     * @param string $expectedResult
     */
    public function it_should_format_list_values(HolidayList $holidayList, $expectedResult)
    {
        $this->givenAFormatter();
        $this->whenFormatListIsCalled($holidayList);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param HolidayList $holidayList
     */
    private function whenFormatListIsCalled(HolidayList $holidayList)
    {
        $this->actualResult = $this->formatter->formatList($holidayList);
    }

    /**
     * @return array
     */
    public function getFormatListData()
    {
        return [
            [
                new HolidayList(),
                '[]',
            ],
            [
                new HolidayList([
                    new Holiday('name', new DateTime('2016-03-17', $this->getTimezone()), HolidayType::OTHER),
                    new Holiday('name', new DateTime('2016-03-18', $this->getTimezone()), HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
                ]),
                '[{
                    "name": "name",
                    "translatedName": "name",
                    "timestamp": 1458172800,
                    "formattedDate": "20160317T000000Z+0000",
                    "type": 0,
                    "formattedType": [
                        "other"
                    ]
                },
                {
                    "name": "name",
                    "translatedName": "name",
                    "timestamp": 1458259200,
                    "formattedDate": "20160318T000000Z+0000",
                    "type": 6,
                    "formattedType": [
                        "day_off",
                        "religious"
                    ]
                }]',
            ],
        ];
    }
}
