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
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\Belgium\Belgium;
use Umulmrum\Holiday\Provider\Germany\Berlin;
use Umulmrum\Holiday\Provider\Germany\Brandenburg;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Provider\Germany\Hesse;
use Umulmrum\Holiday\Provider\Germany\Saxony;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Resolver\ResolverHandlerInterface;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\ResolverHandlerStub;

final class HolidayCalculatorTest extends HolidayTestCase
{
    /**
     * @var HolidayCalculator
     */
    private $holidayCalculator;
    /**
     * @var HolidayList
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider provideDataForTestDefaultResolver
     *
     * @param string|HolidayProviderInterface[] $holidayProviders
     * @param int|int[]                         $years
     */
    public function it_calculates_with_default_resolver($holidayProviders, $years): void
    {
        $this->givenHolidayCalculator();
        $this->whenCalculateIsCalled($holidayProviders, $years);
        $this->thenNoExceptionShouldBeThrown();
    }

    public function provideDataForTestDefaultResolver(): array
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
            [
                'DE',
                2020,
            ],
        ];
    }

    private function givenHolidayCalculator(ResolverHandlerInterface $resolverHandler = null): void
    {
        $this->holidayCalculator = new HolidayCalculator($resolverHandler);
    }

    private function whenCalculateIsCalled($holidayProviders, $years): void
    {
        $this->actualResult = $this->holidayCalculator->calculate($holidayProviders, $years);
    }

    private function thenNoExceptionShouldBeThrown(): void
    {
        self::assertTrue(true);
    }

    /**
     * @test
     * @dataProvider provideDataForTestThrowExceptionOnInvalidArgument
     *
     * @param mixed $holidayProviders
     * @param mixed $years
     */
    public function it_throws_exception_on_invalid_arguments($holidayProviders, $years): void
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

    /**
     * @test
     */
    public function it_uses_passed_resolver_handler(): void
    {
        $this->givenHolidayCalculator(new ResolverHandlerStub());
        $this->whenCalculateIsCalled('x', 2020);
        $this->thenExpectedHolidaysShouldBeReturned(['2020-01-01', '2020-07-07']);
    }

    /**
     * @param string[] $expectedHolidays
     */
    private function thenExpectedHolidaysShouldBeReturned(array $expectedHolidays): void
    {
        self::assertEquals($expectedHolidays, \array_map(static function (Holiday $holiday) {
            return $holiday->getSimpleDate();
        }, $this->actualResult->getList()));
    }
}
