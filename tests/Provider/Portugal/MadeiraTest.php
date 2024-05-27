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

use Umulmrum\Holiday\Provider\Portugal\Madeira;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class MadeiraTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [Madeira::class];
    }

    public static function getData(): array
    {
        return [
            [
                1978,
                [
                    '1978-01-01',
                    '1978-03-24',
                    '1978-03-26',
                    '1978-04-25',
                    '1978-05-01',
                    '1978-05-25',
                    '1978-06-10',
                    '1978-08-15',
                    '1978-10-05',
                    '1978-11-01',
                    '1978-12-01',
                    '1978-12-08',
                    '1978-12-25',
                ],
            ],
            [
                1979,
                [
                    '1979-01-01',
                    '1979-04-13',
                    '1979-04-15',
                    '1979-04-25',
                    '1979-05-01',
                    '1979-06-10',
                    '1979-06-14',
                    '1979-07-01',
                    '1979-08-15',
                    '1979-10-05',
                    '1979-11-01',
                    '1979-12-01',
                    '1979-12-08',
                    '1979-12-25',
                ],
            ],
            [
                2001,
                [
                    '2001-01-01',
                    '2001-04-13',
                    '2001-04-15',
                    '2001-04-25',
                    '2001-05-01',
                    '2001-06-10',
                    '2001-06-14',
                    '2001-07-01',
                    '2001-08-15',
                    '2001-10-05',
                    '2001-11-01',
                    '2001-12-01',
                    '2001-12-08',
                    '2001-12-25',
                ],
            ],
            [
                2002,
                [
                    '2002-01-01',
                    '2002-03-29',
                    '2002-03-31',
                    '2002-04-25',
                    '2002-05-01',
                    '2002-05-30',
                    '2002-06-10',
                    '2002-07-01',
                    '2002-08-15',
                    '2002-10-05',
                    '2002-11-01',
                    '2002-12-01',
                    '2002-12-08',
                    '2002-12-25',
                    '2002-12-26',
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
                    '2024-05-30',
                    '2024-06-10',
                    '2024-07-01',
                    '2024-08-15',
                    '2024-10-05',
                    '2024-11-01',
                    '2024-12-01',
                    '2024-12-08',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
        ];
    }
}
