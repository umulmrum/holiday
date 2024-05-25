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

use Umulmrum\Holiday\Provider\UnitedKingdom\UnitedKingdom;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class UnitedKingdomTest extends AbstractHolidayCalculatorTestCase
{
    public static function getData(): array
    {
        return [
            [
                1964,
                [
                    '1964-01-01',
                    '1964-03-27',
                    '1964-03-30',
                    '1964-05-18',
                    '1964-05-25',
                    '1964-08-03',
                    '1964-12-25',
                    '1964-12-26',
                    '1964-12-28',
                ],
            ],
            [
                1968,
                [
                    '1968-01-01',
                    '1968-03-15',
                    '1968-04-12',
                    '1968-04-15',
                    '1968-05-27',
                    '1968-09-02',
                    '1968-12-25',
                    '1968-12-26',
                ],
            ],
            [
                1969,
                [
                    '1969-01-01',
                    '1969-04-04',
                    '1969-04-07',
                    '1969-05-26',
                    '1969-09-01',
                    '1969-12-25',
                    '1969-12-26',
                ],
            ],
            [
                1973,
                [
                    '1973-01-01',
                    '1973-04-20',
                    '1973-04-23',
                    '1973-05-28',
                    '1973-08-27',
                    '1973-11-14',
                    '1973-12-25',
                    '1973-12-26',
                ],
            ],
            [
                1977,
                [
                    '1977-01-01',
                    '1977-01-03',
                    '1977-04-08',
                    '1977-04-11',
                    '1977-05-30',
                    '1977-07-07',
                    '1977-08-29',
                    '1977-12-25',
                    '1977-12-26',
                    '1977-12-27',
                ],
            ],
            [
                1981,
                [
                    '1981-01-01',
                    '1981-04-17',
                    '1981-04-20',
                    '1981-05-04',
                    '1981-05-25',
                    '1981-07-29',
                    '1981-08-31',
                    '1981-12-25',
                    '1981-12-26',
                    '1981-12-28',
                ],
            ],
            [
                1995,
                [
                    '1995-01-01',
                    '1995-01-02',
                    '1995-04-14',
                    '1995-04-17',
                    '1995-05-08',
                    '1995-05-29',
                    '1995-08-28',
                    '1995-12-25',
                    '1995-12-26',
                ],
            ],
            [
                1999,
                [
                    '1999-01-01',
                    '1999-04-02',
                    '1999-04-05',
                    '1999-05-03',
                    '1999-05-31',
                    '1999-08-30',
                    '1999-12-25',
                    '1999-12-26',
                    '1999-12-27',
                    '1999-12-28',
                    '1999-12-31',
                ],
            ],
            [
                2002,
                [
                    '2002-01-01',
                    '2002-03-29',
                    '2002-04-01',
                    '2002-05-06',
                    '2002-06-02',
                    '2002-06-04',
                    '2002-08-26',
                    '2002-12-25',
                    '2002-12-26',
                ],
            ],
            [
                2011,
                [
                    '2011-01-01',
                    '2011-01-03',
                    '2011-04-22',
                    '2011-04-25',
                    '2011-04-29',
                    '2011-05-02',
                    '2011-05-30',
                    '2011-08-29',
                    '2011-12-25',
                    '2011-12-26',
                    '2011-12-27',
                ],
            ],
            [
                2012,
                [
                    '2012-01-01',
                    '2012-01-02',
                    '2012-04-06',
                    '2012-04-09',
                    '2012-05-07',
                    '2012-06-04',
                    '2012-06-05',
                    '2012-08-27',
                    '2012-12-25',
                    '2012-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-08',
                    '2020-05-25',
                    '2020-08-31',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-28',
                ],
            ],
            [
                2022,
                [
                    '2022-01-01',
                    '2022-01-03',
                    '2022-04-15',
                    '2022-04-18',
                    '2022-05-02',
                    '2022-06-02',
                    '2022-06-03',
                    '2022-08-29',
                    '2022-09-19',
                    '2022-12-25',
                    '2022-12-26',
                    '2022-12-27',
                ],
            ],
            [
                2023,
                [
                    '2023-01-01',
                    '2023-01-02',
                    '2023-04-07',
                    '2023-04-10',
                    '2023-05-01',
                    '2023-05-08',
                    '2023-05-29',
                    '2023-08-28',
                    '2023-12-25',
                    '2023-12-26',
                ],
            ],
            [
                2024,
                [
                    '2024-01-01',
                    '2024-03-29',
                    '2024-04-01',
                    '2024-05-06',
                    '2024-05-27',
                    '2024-08-26',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
        ];
    }

    protected function getHolidayProviders(): array
    {
        return [UnitedKingdom::class];
    }
}