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

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
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

use function array_map;

final class HolidayCalculatorTest extends HolidayTestCase
{
    private HolidayCalculator $holidayCalculator;
    private HolidayList $actualResult;

    /**
     * @param HolidayProviderInterface[]|string $holidayProviders
     * @param int|int[]                         $years
     */
    #[DataProvider('provideDataForTestDefaultResolver')]
    #[Test]
    public function itCalculatesWithDefaultResolver($holidayProviders, $years): void
    {
        $this->givenHolidayCalculator();
        $this->whenCalculateIsCalled($holidayProviders, $years);
        $this->thenNoExceptionShouldBeThrown();
    }

    public static function provideDataForTestDefaultResolver(): array
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

    private function givenHolidayCalculator(?ResolverHandlerInterface $resolverHandler = null): void
    {
        $this->holidayCalculator = new HolidayCalculator($resolverHandler);
    }

    /**
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $holidayProviders
     * @param int|int[]                                                           $years
     */
    private function whenCalculateIsCalled($holidayProviders, $years): void
    {
        $this->actualResult = $this->holidayCalculator->calculate($holidayProviders, $years);
    }

    private function thenNoExceptionShouldBeThrown(): void
    {
        self::assertTrue(true);
    }

    #[DataProvider('provideDataForTestThrowExceptionOnInvalidArgument')]
    #[Test]
    public function itThrowsExceptionOnInvalidArguments(mixed $holidayProviders, mixed $years): void
    {
        $this->givenHolidayCalculator();
        $this->thenExpectInvalidArgumentException();
        $this->whenCalculateIsCalled($holidayProviders, $years);
    }

    public static function provideDataForTestThrowExceptionOnInvalidArgument(): array
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
                new stdClass(),
                2020,
            ],
            [
                [
                    Germany::class,
                    new stdClass(),
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
        $this->expectException(InvalidArgumentException::class);
    }

    #[Test]
    public function itUsesPassedResolverHandler(): void
    {
        $this->givenHolidayCalculator(new ResolverHandlerStub());
        $this->whenCalculateIsCalled('x', 2020);
        $this->thenExpectedHolidaysShouldBeReturned(['2020-01-02', '2020-07-07']);
    }

    /**
     * @param string[] $expectedHolidays
     */
    private function thenExpectedHolidaysShouldBeReturned(array $expectedHolidays): void
    {
        self::assertEquals($expectedHolidays, array_map(static fn (Holiday $holiday) => $holiday->getSimpleDate(), $this->actualResult->getList()));
    }
}
