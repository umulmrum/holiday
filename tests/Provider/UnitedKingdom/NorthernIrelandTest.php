<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\UnitedKingdom;

use Umulmrum\Holiday\Provider\UnitedKingdom\NorthernIreland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class NorthernIrelandTest extends AbstractHolidayCalculatorTestCase
{
    public static function getData(): array
    {
        return [
            [
                2014,
                [
                    '2014-01-01',
                    '2014-03-17',
                    '2014-04-18',
                    '2014-04-21',
                    '2014-05-05',
                    '2014-05-26',
                    '2014-07-12',
                    '2014-07-14',
                    '2014-08-25',
                    '2014-12-25',
                    '2014-12-26',
                ],
            ],
            [
                2018,
                [
                    '2018-01-01',
                    '2018-03-17',
                    '2018-03-19',
                    '2018-03-30',
                    '2018-04-02',
                    '2018-05-07',
                    '2018-05-28',
                    '2018-07-12',
                    '2018-08-27',
                    '2018-12-25',
                    '2018-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-03-17',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-08',
                    '2020-05-25',
                    '2020-07-12',
                    '2020-07-13',
                    '2020-08-31',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-28',
                ],
            ],
            [
                2024,
                [
                    '2024-01-01',
                    '2024-03-17',
                    '2024-03-18',
                    '2024-03-29',
                    '2024-04-01',
                    '2024-05-06',
                    '2024-05-27',
                    '2024-07-12',
                    '2024-08-26',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
        ];
    }

    protected function getHolidayProviders(): array
    {
        return [NorthernIreland::class];
    }
}
