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

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Italy\Italy;
use Umulmrum\Holiday\Provider\Switzerland\Bern;
use Umulmrum\Holiday\Resolver\ClassNameResolver;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class ClassNameResolverTest extends HolidayTestCase
{
    /**
     * @var ClassNameResolver
     */
    private $subject;
    /**
     * @var HolidayProviderInterface|null
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider provideDataForResolveProviders
     */
    public function it_should_resolve_providers(string $identifier, HolidayProviderInterface $expectedResult = null): void
    {
        $this->givenClassNameResolver();
        $this->whenResolveHolidayProviderIsCalled($identifier);
        $this->thenTheExpectedResultShouldBeReturned($expectedResult);
    }

    public function provideDataForResolveProviders(): array
    {
        return [
            [
                Italy::class,
                new Italy(),
            ],
            [
                '\Umulmrum\Holiday\Provider\Switzerland\Bern',
                new Bern(),
            ],
            [
                'foo',
                null,
            ],
        ];
    }

    /**
     * @test
     */
    public function it_should_throw_exception_on_invalid_class(): void
    {
        $this->givenClassNameResolver();
        $this->thenExpectInvalidArgumentException();
        $this->whenResolveHolidayProviderIsCalled(HolidayCalculator::class);
    }

    private function givenClassNameResolver(): void
    {
        $this->subject = new ClassNameResolver();
    }

    private function whenResolveHolidayProviderIsCalled(string $identifier): void
    {
        $this->actualResult = $this->subject->resolveHolidayProvider($identifier);
    }

    private function thenTheExpectedResultShouldBeReturned(?HolidayProviderInterface $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    private function thenExpectInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
    }
}
