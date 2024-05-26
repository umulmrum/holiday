<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Iceland;

use Umulmrum\Holiday\Provider\Iceland\Iceland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class IcelandTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [
            Iceland::class,
        ];
    }

    public static function getData(): array
    {
        return [
            [
                2024,
                [
                    '2024-01-01',
                    '2024-03-28',
                    '2024-03-29',
                    '2024-03-31',
                    '2024-04-01',
                    '2024-04-25',
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-19',
                    '2024-05-20',
                    '2024-06-17',
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
                    '2025-04-17',
                    '2025-04-18',
                    '2025-04-20',
                    '2025-04-21',
                    '2025-04-24',
                    '2025-05-01',
                    '2025-05-29',
                    '2025-06-08',
                    '2025-06-09',
                    '2025-06-17',
                    '2025-12-24',
                    '2025-12-25',
                    '2025-12-26',
                    '2025-12-31',
                ],
            ],
        ];
    }
}
