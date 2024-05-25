<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Greenland;

use Umulmrum\Holiday\Provider\Greenland\Greenland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class GreenlandTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [
            Greenland::class,
        ];
    }

    public static function getData(): array
    {
        return [
            [
                1984,
                [
                    '1984-01-01',
                    '1984-04-19',
                    '1984-04-20',
                    '1984-04-22',
                    '1984-04-23',
                    '1984-05-01',
                    '1984-05-31',
                    '1984-06-10',
                    '1984-06-11',
                    '1984-12-24',
                    '1984-12-25',
                    '1984-12-26',
                    '1984-12-31',
                ],
            ],
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
                    '2024-05-19',
                    '2024-05-20',
                    '2024-06-21',
                    '2024-12-24',
                    '2024-12-25',
                    '2024-12-26',
                    '2024-12-31',
                ],
            ],
        ];
    }
}
