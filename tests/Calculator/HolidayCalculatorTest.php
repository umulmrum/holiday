<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Calculator;

use umulmrum\Holiday\HolidayCalculator;
use umulmrum\Holiday\Provider\Belgium\Belgium;
use umulmrum\Holiday\Provider\Germany\Berlin;
use umulmrum\Holiday\Provider\Germany\Brandenburg;
use umulmrum\Holiday\Provider\Germany\Germany;
use umulmrum\Holiday\Provider\Germany\Hesse;
use umulmrum\Holiday\Provider\Germany\Saxony;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Test\HolidayTestCase;

final class HolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    private $holidayCalculator;

    /**
     * @dataProvider provideDataForTestConstructForValidArgument
     *
     * @param string|HolidayProviderInterface[] $holidayProviders
     * @param int|int[]                         $years
     */
    public function testConstructForValidArgument($holidayProviders, $years): void
    {
        $this->givenHolidayCalculator();
        $this->whenCalculateIsCalled($holidayProviders, $years);
        $this->thenNoExceptionShouldBeThrown();
    }

    public function provideDataForTestConstructForValidArgument(): array
    {
        return [
            [
                Germany::class,
                2020,
            ],
            [
                new Hesse(),
                [2020, 2021],
            ],
            [
                [
                    new Germany(),
                    Brandenburg::class,
                    Berlin::class,
                    new Saxony(),
                ],
                [2020],
            ],
        ];
    }

    private function givenHolidayCalculator(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

    private function whenCalculateIsCalled($holidayProviders, $years): void
    {
        $this->holidayCalculator->calculate($holidayProviders, $years);
    }

    private function thenNoExceptionShouldBeThrown(): void
    {
        self::assertTrue(true);
    }

    /**
     * @dataProvider provideDataForTestThrowExceptionOnInvalidArgument
     *
     * @param mixed $holidayProviders
     * @param mixed $years
     */
    public function testThrowExceptionOnInvalidArgument($holidayProviders, $years): void
    {
        $this->givenHolidayCalculator();
        $this->thenExpectInvalidArgumentException();
        $this->whenCalculateIsCalled($holidayProviders, $years);
    }

    public function provideDataForTestThrowExceptionOnInvalidArgument(): array
    {
        return [
            [
                null,
                2020,
            ],
            [
                1,
                2020,
            ],
            [
                'no class name',
                2020,
            ],
            [
                HolidayCalculator::class,
                2020,
            ],
            [
                new \stdClass(),
                2020,
            ],
            [
                [
                    Germany::class,
                    new \stdClass(),
                ],
                2020,
            ],
            [
                Belgium::class,
                'string',
            ],
            [
                Belgium::class,
                null,
            ],
            [
                Belgium::class,
                false,
            ],
            [
                Belgium::class,
                [2020, 'foo'],
            ],

        ];
    }

    private function thenExpectInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }
}
