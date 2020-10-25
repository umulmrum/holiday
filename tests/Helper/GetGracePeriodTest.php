<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Helper;

use umulmrum\Holiday\Helper\GetGracePeriod;
use umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use umulmrum\Holiday\Provider\Weekday\Saturdays;
use umulmrum\Holiday\Provider\Weekday\Sundays;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Provider\Germany\Germany;

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
    public function it_should_calculate_correct_grace_period($holidayProviders, \DateTime $firstDay, int $numberOfDays, \DateTimeInterface $expectedResult): void
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
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-01 12:34:56'),
                7,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-08 12:34:56'),
            ],
            'weekend' => [
                [Saturdays::class, Sundays::class],
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-01 12:34:56'),
                7,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-10 12:34:56'),
            ],
            'leap-day-and-two-weekends' => [
                [Saturdays::class, Sundays::class],
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-28 00:00:00'),
                7,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-03-10 00:00:00'),
            ],
            'daylight-saving' => [
                [Saturdays::class, Sundays::class],
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-10-24 15:48:33'),
                2,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-10-28 15:48:33'),
            ],
            'multiple-weekends-and-holidays-with-new-year' => [
                [BadenWuerttemberg::class, Saturdays::class, Sundays::class],
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-23 23:59:59'),
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2021-01-13 23:59:59'),
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

    private function whenGetGracePeriodIsCalled($holidayProviders, \DateTime $firstDay, int $numberOfDays): void
    {
        $this->actualResult = ($this->subject)($holidayProviders, $firstDay, $numberOfDays);
    }
}
