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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidays;
use Umulmrum\Holiday\Provider\Weekday\Fridays;
use Umulmrum\Holiday\Provider\Weekday\Mondays;
use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Provider\Weekday\Sundays;
use Umulmrum\Holiday\Provider\Weekday\Thursdays;
use Umulmrum\Holiday\Provider\Weekday\Tuesdays;
use Umulmrum\Holiday\Provider\Weekday\Wednesdays;
use Umulmrum\Holiday\Resolver\MiscResolver;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class MiscResolverTest extends HolidayTestCase
{
    private MiscResolver $subject;
    private ?HolidayProviderInterface $actualResult;

    #[DataProvider('provideDataForResolveProviders')]
    #[Test]
    public function it_should_resolve_providers(string $identifier, ?HolidayProviderInterface $expectedResult = null): void
    {
        $this->givenMiscResolver();
        $this->whenResolveHolidayProviderIsCalled($identifier);
        $this->thenTheExpectedResultShouldBeReturned($expectedResult);
    }

    public static function provideDataForResolveProviders(): array
    {
        return [
            'christian' => [
                'Christian',
                new ChristianHolidays(),
            ],
            'sunday' => [
                'Sun',
                new Sundays(),
            ],
            'monday' => [
                'Mon',
                new Mondays(),
            ],
            'tuesday' => [
                'Tue',
                new Tuesdays(),
            ],
            'wednesday' => [
                'Wed',
                new Wednesdays(),
            ],
            'thursday' => [
                'Thu',
                new Thursdays(),
            ],
            'friday' => [
                'Fri',
                new Fridays(),
            ],
            'saturday' => [
                'Sat',
                new Saturdays(),
            ],
            'wrong-case' => [
                'christian',
                null,
            ],
            'nonexisting' => [
                'foo',
                null,
            ],
        ];
    }

    private function givenMiscResolver(): void
    {
        $this->subject = new MiscResolver();
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
