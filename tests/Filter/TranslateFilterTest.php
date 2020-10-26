<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Filter;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Filter\ApplyTimezoneFilter;
use umulmrum\Holiday\Filter\TranslateFilter;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Test\TranslatorStub;

final class TranslateFilterTest extends HolidayTestCase
{
    /**
     * @var ApplyTimezoneFilter
     */
    private $filter;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getData
     *
     * @param Holiday[] $holidays
     * @param Holiday[] $expectedResult
     */
    public function it_should_filter_holidays(array $holidays, array $expectedResult): void
    {
        $this->givenTranslateFilter();
        $this->whenFilterIsCalled($holidays);
        $this->thenACorrectlyFilteredResultShouldBeReturned($expectedResult);
    }

    private function givenTranslateFilter(): void
    {
        $this->filter = new TranslateFilter(new TranslatorStub());
    }

    private function whenFilterIsCalled(array $holidays): void
    {
        $this->actualResult = (new HolidayList($holidays))->filter($this->filter);
    }

    /**
     * @param Holiday[] $expectedResult
     */
    private function thenACorrectlyFilteredResultShouldBeReturned(array $expectedResult): void
    {
        self::assertEquals(new HolidayList($expectedResult), $this->actualResult);
    }

    public function getData(): array
    {
        return [
            [
                [
                    Holiday::create('name', '2020-02-03', HolidayType::BANK),
                    Holiday::create('day_off', '2020-05-23', HolidayType::DAY_OFF),
                ],
                [
                    Holiday::create('Very name', '2020-02-03', HolidayType::BANK),
                    Holiday::create('Day off', '2020-05-23', HolidayType::DAY_OFF),
                ],
            ],
        ];
    }
}
