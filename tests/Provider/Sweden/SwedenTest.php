<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Sweden;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Provider\Sweden\Sweden;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class SwedenTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [
            Sweden::class,
        ];
    }

    public static function getData(): array
    {
        return [
            [
                2024,
                [
                    '2024-01-01',
                    '2024-01-05',
                    '2024-01-06',
                    '2024-03-29',
                    '2024-03-31',
                    '2024-04-01',
                    '2024-04-30',
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-19',
                    '2024-06-06',
                    '2024-06-21',
                    '2024-06-22',
                    '2024-11-01',
                    '2024-11-02',
                    '2024-12-24',
                    '2024-12-25',
                    '2024-12-26',
                    '2024-12-31',
                ],
            ],
            [
                2025,
                [
                    '2025-01-01',
                    '2025-01-05',
                    '2025-01-06',
                    '2025-04-18',
                    '2025-04-20',
                    '2025-04-21',
                    '2025-04-30',
                    '2025-05-01',
                    '2025-05-29',
                    '2025-06-06',
                    '2025-06-08',
                    '2025-06-20',
                    '2025-06-21',
                    '2025-10-31',
                    '2025-11-01',
                    '2025-12-24',
                    '2025-12-25',
                    '2025-12-26',
                    '2025-12-31',
                ],
            ],
        ];
    }

    #[DataProvider('getDataForCalculateWithDeFactoHolidays')]
    #[Test]
    public function it_computes_the_correct_holidays_without_de_facto_holidays(int $year, array $expectedResult): void
    {
        $this->givenAHolidayCalculator();
        $this->whenICallCalculateForSwedenWithoutDeFactoHolidays($year);
        $this->thenTheCorrectHolidaysShouldBeCalculated($expectedResult);
    }

    private function whenICallCalculateForSwedenWithoutDeFactoHolidays(int $year): void
    {
        $this->actualResult = $this->holidayCalculator->calculate([new Sweden(false, false)], $year);
    }

    public static function getDataForCalculateWithDeFactoHolidays(): array
    {
        return [
            [
                2024,
                [
                    '2024-01-01',
                    '2024-01-06',
                    '2024-03-29',
                    '2024-03-31',
                    '2024-04-01',
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-19',
                    '2024-06-06',
                    '2024-06-22',
                    '2024-11-02',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
            [
                2025,
                [
                    '2025-01-01',
                    '2025-01-06',
                    '2025-04-18',
                    '2025-04-20',
                    '2025-04-21',
                    '2025-05-01',
                    '2025-05-29',
                    '2025-06-06',
                    '2025-06-08',
                    '2025-06-21',
                    '2025-11-01',
                    '2025-12-25',
                    '2025-12-26',
                ],
            ],
        ];
    }
}
