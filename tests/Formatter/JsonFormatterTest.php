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
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Formatter\JsonFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;

final class JsonFormatterTest extends HolidayTestCase
{
    private JsonFormatter $formatter;

    /**
     * @var string|string[]
     */
    private array|string $actualResult;

    #[DataProvider('getFormatData')]
    #[Test]
    public function itShouldFormatSingleValues(Holiday $holiday, string $expectedResult): void
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                Holiday::create('name', '2016-03-17', HolidayType::OTHER),
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
                Holiday::create('name', '2016-03-17', HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
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

    private function givenAFormatter(): void
    {
        $this->formatter = new JsonFormatter();
    }

    private function whenFormatIsCalled(Holiday $holiday): void
    {
        $this->actualResult = $this->formatter->format($holiday);
    }

    private function thenAFormattedResultShouldBeReturned(string $expectedResult): void
    {
        self::assertJsonStringEqualsJsonString($expectedResult, $this->actualResult); // @phpstan-ignore-line
    }

    #[DataProvider('getFormatTranslatedData')]
    #[Test]
    public function itShouldFormatSingleValuesWithTranslation(Holiday $holiday, string $expectedResult): void
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatTranslatedData(): array
    {
        return [
            [
                Holiday::create('name', '2016-03-17', HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
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

    private function givenAFormatterWithTranslator(): void
    {
        $this->formatter = new JsonFormatter(new TranslatorStub());
    }

    #[DataProvider('getFormatListData')]
    #[Test]
    public function itShouldFormatListValues(HolidayList $holidayList, string $expectedResult): void
    {
        $this->givenAFormatter();
        $this->whenFormatListIsCalled($holidayList);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                new HolidayList(),
                '[]',
            ],
            [
                new HolidayList([
                    Holiday::create('name', '2016-03-17', HolidayType::OTHER),
                    Holiday::create('name', '2016-03-18', HolidayType::RELIGIOUS | HolidayType::DAY_OFF),
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

    private function whenFormatListIsCalled(HolidayList $holidayList): void
    {
        $this->actualResult = $this->formatter->formatList($holidayList);
    }
}
