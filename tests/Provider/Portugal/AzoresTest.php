<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Portugal;

use Umulmrum\Holiday\Provider\Portugal\Azores;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class AzoresTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [Azores::class];
    }

    public static function getData(): array
    {
        return [
            [
                1980,
                [
                    '1980-01-01',
                    '1980-04-04',
                    '1980-04-06',
                    '1980-04-25',
                    '1980-05-01',
                    '1980-06-05',
                    '1980-06-10',
                    '1980-08-15',
                    '1980-10-05',
                    '1980-11-01',
                    '1980-12-01',
                    '1980-12-08',
                    '1980-12-25',
                ],
            ],
            [
                1981,
                [
                    '1981-01-01',
                    '1981-04-17',
                    '1981-04-19',
                    '1981-04-25',
                    '1981-05-01',
                    '1981-06-08',
                    '1981-06-10',
                    '1981-06-18',
                    '1981-08-15',
                    '1981-10-05',
                    '1981-11-01',
                    '1981-12-01',
                    '1981-12-08',
                    '1981-12-25',
                ],
            ],
            [
                2024,
                [
                    '2024-01-01',
                    '2024-03-29',
                    '2024-03-31',
                    '2024-04-25',
                    '2024-05-01',
                    '2024-05-20',
                    '2024-05-30',
                    '2024-06-10',
                    '2024-08-15',
                    '2024-10-05',
                    '2024-11-01',
                    '2024-12-01',
                    '2024-12-08',
                    '2024-12-25',
                ],
            ],
        ];
    }
}
