<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Resolver;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Austria\Vienna;
use Umulmrum\Holiday\Provider\Brazil\Brazil;
use Umulmrum\Holiday\Provider\Denmark\Denmark;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Switzerland\Solothurn;
use Umulmrum\Holiday\Provider\Weekday\Sundays;
use Umulmrum\Holiday\Provider\Weekday\Wednesdays;
use Umulmrum\Holiday\Resolver\ClassNameResolver;
use Umulmrum\Holiday\Resolver\IsoResolver;
use Umulmrum\Holiday\Resolver\ProviderResolverInterface;
use Umulmrum\Holiday\Resolver\ResolverHandler;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class ResolverHandlerTest extends HolidayTestCase
{
    /**
     * @var ResolverHandler
     */
    private $subject;
    /**
     * @var HolidayProviderInterface[]
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider provideDataForResolveHolidayProviders
     *
     * @param ProviderResolverInterface[]                                         $providers
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $identifier
     * @param HolidayProviderInterface[]                                          $expectedResult
     */
    public function it_resolves_holiday_providers(array $providers, $identifier, array $expectedResult): void
    {
        $this->givenResolverHandler($providers);
        $this->whenResolveIsCalled($identifier);
        $this->thenTheExpectedProvidersShouldBeReturned($expectedResult);
    }

    public function provideDataForResolveHolidayProviders(): array
    {
        return [
            'always-resolve-class-instance' => [
                [],
                new Sundays(HolidayType::DAY_OFF),
                [new Sundays(HolidayType::DAY_OFF)],
            ],
            'single-resolver' => [
                [new ClassNameResolver()],
                Brazil::class,
                [new Brazil()],
            ],
            'multiple-resolvers' => [
                [new ClassNameResolver(), new IsoResolver()],
                [Solothurn::class, 'AT-9', new Wednesdays(HolidayType::OFFICIAL)],
                [new Solothurn(), new Vienna(), new Wednesdays(HolidayType::OFFICIAL)],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDataForThrowException
     *
     * @param mixed $identifier
     */
    public function it_throws_exception_for_invalid_identifier($identifier): void
    {
        $this->givenResolverHandler([new ClassNameResolver()]);
        $this->thenExpectInvalidArgumentException();
        $this->whenResolveIsCalled($identifier);
    }

    public function provideDataForThrowException(): array
    {
        return [
            [1],
            [null],
            [true],
            [new HolidayCalculator()],
            [[new Brazil(), 'foo']],
            [[Denmark::class, 1337]],
        ];
    }

    /**
     * @param ProviderResolverInterface[] $providers
     */
    private function givenResolverHandler(array $providers): void
    {
        $this->subject = new ResolverHandler($providers);
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $identifier
     */
    private function whenResolveIsCalled($identifier): void
    {
        $this->actualResult = $this->subject->resolve($identifier);
    }

    /**
     * @param HolidayProviderInterface[] $expectedResult
     */
    private function thenTheExpectedProvidersShouldBeReturned(array $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    private function thenExpectInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }
}
