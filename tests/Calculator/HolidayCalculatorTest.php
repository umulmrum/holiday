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

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Provider\Germany\Berlin;
use umulmrum\Holiday\Provider\Germany\Brandenburg;
use umulmrum\Holiday\Provider\Germany\Germany;
use umulmrum\Holiday\Provider\Germany\Hesse;
use umulmrum\Holiday\Provider\Germany\Saxony;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

final class HolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    private $holidayCalculator;

    /**
     * @dataProvider provideDataForTestConstructForValidArgument
     *
     * @param string|HolidayProviderInterface[] $argument
     */
    public function testConstructForValidArgument($argument): void
    {
        $this->givenHolidayCalculator();
        $this->whenCalculateIsCalled($argument);
        $this->thenNoExceptionShouldBeThrown();
    }

    public function provideDataForTestConstructForValidArgument(): array
    {
        return [
            [
                Germany::class,
            ],
            [
                new Hesse(),
            ],
            [
                new Germany(),
                Brandenburg::class,
                Berlin::class,
                new Saxony(),
            ],
        ];
    }

    private function givenHolidayCalculator(): void
    {
        $this->holidayCalculator = new HolidayCalculator();
    }

    private function whenCalculateIsCalled($argument): void
    {
        $this->holidayCalculator->calculate($argument, 2018);
    }

    private function thenNoExceptionShouldBeThrown(): void
    {
        self::assertTrue(true);
    }

    /**
     * @dataProvider provideDataForTestThrowExceptionOnInvalidArgument
     *
     * @param mixed $argument
     */
    public function testThrowExceptionOnInvalidArgument($argument): void
    {
        $this->givenHolidayCalculator();
        $this->thenExpectInvalidArgumentException();
        $this->whenCalculateIsCalled($argument);
    }

    public function provideDataForTestThrowExceptionOnInvalidArgument(): array
    {
        return [
            [
                null,
            ],
            [
                1,
            ],
            [
                'no class name',
            ],
            [
                HolidayCalculator::class,
            ],
            [
                new \stdClass(),
            ],
            [
                [
                    Germany::class,
                    new \stdClass(),
                ],
            ],
        ];
    }

    private function thenExpectInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }
}
