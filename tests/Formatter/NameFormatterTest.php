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
use umulmrum\Holiday\Translator\TranslatorInterface;

class NameFormatterTest extends HolidayTestCase
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
        $holiday = new Holiday($name, new \DateTime('2016-01-01'));
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
        $this->givenAFormatterWithTranslator([$name], [$expectedResult]);
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[] $names
     * @param string[] $expectedResults
     */
    private function givenAFormatterWithTranslator(array $names, array $expectedResults): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        for ($i = 0; $i < $count = count($names); ++$i) {
            $translator->translateName(new Holiday($names[$i], new \DateTime('2016-01-01')))->willReturn($expectedResults[$i]);
        }
        $this->formatter = new NameFormatter($translator->reveal());
    }

    public function getFormatTranslatedData(): array
    {
        return [
            [
                'foo',
                'This is foo',
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
        $this->givenAFormatterWithTranslator($names, $expectedResult);
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
            $holidayList->add(new Holiday($name, new \DateTime('2016-01-01')));
        }
        $this->actualResult = $this->formatter->formatList($holidayList);
    }

    public function getFormatListData(): array
    {
        return [
            [
                [
                    'foo',
                    'bar',
                ],
                [
                    'This is foo',
                    'Oh my bar-ness',
                ],
            ],
        ];
    }
}
