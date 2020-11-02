<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Helper;

use Umulmrum\Holiday\Helper\GetGracePeriod;
use Umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Provider\Weekday\Sundays;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class GetGracePeriodTest extends HolidayTestCase
{
    /**
     * @var GetGracePeriod
     */
    private $subject;
    /**
     * @var int
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getGetGracePeriodData
     */
    public function it_should_calculate_correct_grace_period($holidayProviders, \DateTimeImmutable $firstDay, int $numberOfDays, \DateTimeInterface $expectedResult): void
    {
        $this->givenGetGracePeriod();
        $this->whenGetGracePeriodIsCalled($holidayProviders, $firstDay, $numberOfDays);
        $this->thenItShouldReturnTheCorrectGracePeriod($expectedResult);
    }

    public function getGetGracePeriodData(): array
    {
        return [
            'no-holidays' => [
                Germany::class,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-09-01 12:34:56'),
                7,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-09-08 12:34:56'),
            ],
            'weekend' => [
                [Saturdays::class, Sundays::class],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-09-01 12:34:56'),
                7,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-09-10 12:34:56'),
            ],
            'next-working-day-with-no-holidays' => [
                Germany::class,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-26 12:34:56'),
                0,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-26 12:34:56'),
            ],
            'next-working-day-with-holidays-and-weekend' => [
                [Germany::class, Saturdays::class, Sundays::class],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-12-24 12:34:56'),
                0,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-12-28 12:34:56'),
            ],
            'leap-day-and-two-weekends' => [
                [Saturdays::class, Sundays::class],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-28 00:00:00'),
                7,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-10 00:00:00'),
            ],
            'daylight-saving' => [
                [Saturdays::class, Sundays::class],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-24 15:48:33'),
                2,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-28 15:48:33'),
            ],
            'multiple-weekends-and-holidays-with-new-year' => [
                [BadenWuerttemberg::class, Saturdays::class, Sundays::class],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-12-23 23:59:59'),
                10,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2021-01-13 23:59:59'),
            ],
        ];
    }

    private function givenGetGracePeriod(): void
    {
        $this->subject = new GetGracePeriod();
    }

    private function thenItShouldReturnTheCorrectGracePeriod(\DateTimeInterface $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    private function whenGetGracePeriodIsCalled($holidayProviders, \DateTimeImmutable $firstDay, int $numberOfDays): void
    {
        $this->actualResult = ($this->subject)($holidayProviders, $firstDay, $numberOfDays);
    }
}
