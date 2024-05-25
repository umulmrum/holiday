<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Norway;

use Umulmrum\Holiday\Provider\Norway\Norway;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class NorwayTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [
            Norway::class,
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
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-17',
                    '2024-05-19',
                    '2024-05-20',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
        ];
    }
}
