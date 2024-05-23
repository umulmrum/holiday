<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Russia;

use Umulmrum\Holiday\Provider\Russia\Russia;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class RussiaTest extends AbstractHolidayCalculatorTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Russia::class];
    }

    /**
     * {@inheritdoc}
     */
    public static function getData(): array
    {
        return [
            [
                1990,
                [],
            ],
            [
                1991,
                [
                    '1991-01-01',
                    '1991-01-02',
                    '1991-01-07',
                    '1991-02-23',
                    '1991-02-25',
                    '1991-03-08',
                    '1991-05-01',
                    '1991-05-09',
                    '1991-11-07',
                ],
            ],
            [
                1992,
                [
                    '1992-01-01',
                    '1992-01-02',
                    '1992-01-07',
                    '1992-02-23',
                    '1992-02-24',
                    '1992-03-08',
                    '1992-03-09',
                    '1992-05-01',
                    '1992-05-09',
                    '1992-05-11',
                    '1992-06-12',
                    '1992-11-07',
                    '1992-11-09',
                ],
            ],
            [
                2001,
                [
                    '2001-01-01',
                    '2001-01-02',
                    '2001-01-07',
                    '2001-02-23',
                    '2001-03-08',
                    '2001-05-01',
                    '2001-05-09',
                    '2001-06-12',
                    '2001-11-07',
                ],
            ],
            [
                2005,
                [
                    '2005-01-01',
                    '2005-01-02',
                    '2005-01-07',
                    '2005-02-23',
                    '2005-03-08',
                    '2005-05-01',
                    '2005-05-02',
                    '2005-05-09',
                    '2005-06-12',
                    '2005-06-13',
                    '2005-11-04',
                ],
            ],
            [
                2006,
                [
                    '2006-01-01',
                    '2006-01-02',
                    '2006-01-03',
                    '2006-01-04',
                    '2006-01-05',
                    '2006-01-06',
                    '2006-01-07',
                    '2006-01-08',
                    '2006-02-23',
                    '2006-03-08',
                    '2006-05-01',
                    '2006-05-09',
                    '2006-06-12',
                    '2006-11-04',
                    '2006-11-06',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-02',
                    '2020-01-03',
                    '2020-01-04',
                    '2020-01-05',
                    '2020-01-06',
                    '2020-01-07',
                    '2020-01-08',
                    '2020-02-23',
                    '2020-02-24',
                    '2020-03-08',
                    '2020-03-09',
                    '2020-05-01',
                    '2020-05-09',
                    '2020-05-11',
                    '2020-06-12',
                    '2020-11-04',
                ],
            ],
        ];
    }
}
