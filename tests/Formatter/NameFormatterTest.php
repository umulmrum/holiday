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
use Umulmrum\Holiday\Formatter\NameFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;

final class NameFormatterTest extends HolidayTestCase
{
    private NameFormatter $formatter;

    /**
     * @var int|int[]|string|string[]
     */
    private array|int|string $actualResult;

    #[DataProvider('getFormatData')]
    #[Test]
    public function itShouldFormatSingleValues(string $name, string $expectedResult): void
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                'foo',
                'foo',
            ],
        ];
    }

    private function givenAFormatter(): void
    {
        $this->formatter = new NameFormatter();
    }

    private function whenFormatIsCalled(string $name): void
    {
        $holiday = Holiday::create($name, '2016-01-01');
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned($expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    #[DataProvider('getFormatTranslatedData')]
    #[Test]
    public function itShouldFormatSingleValuesWithTranslation(string $name, string $expectedResult): void
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatTranslatedData(): array
    {
        return [
            [
                'day_off',
                'Day off',
            ],
        ];
    }

    private function givenAFormatterWithTranslator(): void
    {
        $this->formatter = new NameFormatter(new TranslatorStub());
    }

    /**
     * @param string[]        $names
     * @param string|string[] $expectedResult
     */
    #[DataProvider('getFormatListData')]
    #[Test]
    public function itShouldFormatListValues(array $names, $expectedResult): void
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatListIsCalled($names);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                [
                    'name',
                    'religious',
                ],
                [
                    'Very name',
                    'Religious',
                ],
            ],
        ];
    }

    /**
     * @param string[] $names
     */
    private function whenFormatListIsCalled(array $names): void
    {
        $holidayList = new HolidayList();
        foreach ($names as $name) {
            $holidayList->add(Holiday::create($name, '2016-01-01'));
        }
        $this->actualResult = $this->formatter->formatList($holidayList);
    }
}
