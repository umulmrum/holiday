<?php

namespace umulmrum\Holiday\Formatter;

use DateTime;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

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
     *
     * @param string $name
     * @param int|string $expectedResult
     */
    public function it_should_format_single_values($name, $expectedResult)
    {
        $this->givenAFormatter();
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatter()
    {
        $this->formatter = new NameFormatter();
    }

    /**
     * @param string $name
     */
    private function whenFormatIsCalled($name)
    {
        $holiday = new Holiday($name, new DateTime('2016-01-01'));
        $this->actualResult = $this->formatter->format($holiday);
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
                'foo',
                'foo',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getFormatTranslatedData
     *
     * @param string $name
     * @param int|string $expectedResult
     */
    public function it_should_format_single_values_with_translation($name, $expectedResult)
    {
        $this->givenAFormatterWithTranslator([$name], [$expectedResult]);
        $this->whenFormatIsCalled($name);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[] $names
     * @param string[] $expectedResults
     */
    private function givenAFormatterWithTranslator(array $names, array $expectedResults)
    {
        $translator = $this->prophesize('\umulmrum\Holiday\Translator\TranslatorInterface');
        for ($i = 0; $i < $count = count($names); $i++) {
            $translator->translateName(new Holiday($names[$i], new DateTime('2016-01-01')))->willReturn($expectedResults[$i]);
        }
        $this->formatter = new NameFormatter($translator->reveal());
    }

    /**
     * @return array
     */
    public function getFormatTranslatedData()
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
     * @param string[] $names
     * @param int|string|int[]|string[] $expectedResult
     */
    public function it_should_format_list_values($names, $expectedResult)
    {
        $this->givenAFormatterWithTranslator($names, $expectedResult);
        $this->whenFormatListIsCalled($names);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    /**
     * @param string[] $names
     */
    private function whenFormatListIsCalled(array $names)
{
        $holidayList = new HolidayList();
        foreach ($names as $name) {
            $holidayList->add(new Holiday($name, new DateTime('2016-01-01')));
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

