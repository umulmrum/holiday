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

use Umulmrum\Holiday\Provider\Belgium\Belgium;
use Umulmrum\Holiday\Provider\France\BasRhin;
use Umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Resolver\IsoResolver;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class IsoResolverTest extends HolidayTestCase
{
    /**
     * @var IsoResolver
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
        $this->givenIsoResolver();
        $this->whenResolveHolidayProviderIsCalled($identifier);
        $this->thenTheExpectedResultShouldBeReturned($expectedResult);
    }

    public function provideDataForResolveProviders(): array
    {
        return [
            [
                'DE',
                new Germany(),
            ],
            [
                'DE-BW',
                new BadenWuerttemberg(),
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
    public function it_should_resolve_multiple_providers_consecutively(): void
    {
        $this->givenIsoResolver();
        $this->whenResolveHolidayProviderIsCalled('FR-67');
        $this->thenTheExpectedResultShouldBeReturned(new BasRhin());

        $this->whenResolveHolidayProviderIsCalled('BE');
        $this->thenTheExpectedResultShouldBeReturned(new Belgium());
    }

    private function givenIsoResolver(): void
    {
        $this->subject = new IsoResolver();
    }

    private function whenResolveHolidayProviderIsCalled(string $identifier): void
    {
        $this->actualResult = $this->subject->resolveHolidayProvider($identifier);
    }

    private function thenTheExpectedResultShouldBeReturned(?HolidayProviderInterface $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }
}
