<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Calculator;

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Belgium\Belgium;
use Umulmrum\Holiday\Provider\Germany\Berlin;
use Umulmrum\Holiday\Provider\Germany\Brandenburg;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Provider\Germany\Hesse;
use Umulmrum\Holiday\Provider\Germany\Saxony;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Test\HolidayTestCase;

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
