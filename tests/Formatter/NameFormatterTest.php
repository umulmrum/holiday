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
use Umulmrum\Holiday\Formatter\NameFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;

final class NameFormatterTest extends HolidayTestCase
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
     */
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

    public function getFormatData(): array
    {
        return [
            [
                'foo',
                'foo',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatTranslatedData
     */
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

    public function getFormatTranslatedData(): array
    {
        return [
            [
                'day_off',
                'Day off',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatListData
     *
     * @param string[]        $names
     * @param string|string[] $expectedResult
     */
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

    public function getFormatListData(): array
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
