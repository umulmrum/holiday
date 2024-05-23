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

use Umulmrum\Holiday\Formatter\NameFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;

final class NameFormatterTest extends HolidayTestCase
{
    /**
     * @var NameFormatter
     */
    private $formatter;
    /**
     * @var int|string|int[]|string[]
     */
    private $actualResult;

    #[\PHPUnit\Framework\Attributes\DataProvider('getFormatData')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_format_single_values(string $name, string $expectedResult): void
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
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

    public static function getFormatData(): array
    {
        return [
            [
                'foo',
                'foo',
            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('getFormatTranslatedData')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_format_single_values_with_translation(string $name, string $expectedResult): void
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatterWithTranslator(): void
    {
        $this->formatter = new NameFormatter(new TranslatorStub());
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

    /**
     * @param string[]        $names
     * @param string|string[] $expectedResult
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getFormatListData')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_format_list_values(array $names, $expectedResult): void
    {
        $this->givenAFormatterWithTranslator();
        $this->whenFormatListIsCalled($names);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
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
}
