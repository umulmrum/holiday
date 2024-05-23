<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Belgium;

use Umulmrum\Holiday\Provider\Belgium\Belgium;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class BelgiumTest extends AbstractHolidayCalculatorTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Belgium::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getData(): array
    {
        return [
            [
                1865,
                [
                    '1865-01-01',
                    '1865-01-06',
                    '1865-02-14',
                    '1865-04-16',
                    '1865-04-17',
                    '1865-05-01',
                    '1865-05-25',
                    '1865-06-04',
                    '1865-06-05',
                    '1865-08-15',
                    '1865-10-31',
                    '1865-11-01',
                    '1865-11-02',
                    '1865-11-11',
                    '1865-12-25',
                ],
            ],
            [
                1866,
                [
                    '1866-01-01',
                    '1866-01-06',
                    '1866-02-14',
                    '1866-04-01',
                    '1866-04-02',
                    '1866-05-01',
                    '1866-05-10',
                    '1866-05-20',
                    '1866-05-21',
                    '1866-08-15',
                    '1866-10-31',
                    '1866-11-01',
                    '1866-11-02',
                    '1866-11-11',
                    '1866-11-15',
                    '1866-12-25',
                ],
            ],
            [
                1890,
                [
                    '1890-01-01',
                    '1890-01-06',
                    '1890-02-14',
                    '1890-04-06',
                    '1890-04-07',
                    '1890-05-01',
                    '1890-05-15',
                    '1890-05-25',
                    '1890-05-26',
                    '1890-07-21',
                    '1890-08-15',
                    '1890-10-31',
                    '1890-11-01',
                    '1890-11-02',
                    '1890-11-11',
                    '1890-11-15',
                    '1890-12-25',
                ],
            ],
            [
                1973,
                [
                    '1973-01-01',
                    '1973-01-06',
                    '1973-02-14',
                    '1973-04-22',
                    '1973-04-23',
                    '1973-05-01',
                    '1973-05-31',
                    '1973-06-10',
                    '1973-06-11',
                    '1973-07-11',
                    '1973-07-21',
                    '1973-08-15',
                    '1973-10-31',
                    '1973-11-01',
                    '1973-11-02',
                    '1973-11-11',
                    '1973-11-15',
                    '1973-12-25',
                ],
            ],
            [
                1975,
                [
                    '1975-01-01',
                    '1975-01-06',
                    '1975-02-14',
                    '1975-03-30',
                    '1975-03-31',
                    '1975-05-01',
                    '1975-05-08',
                    '1975-05-18',
                    '1975-05-19',
                    '1975-07-11',
                    '1975-07-21',
                    '1975-08-15',
                    '1975-09-27',
                    '1975-10-31',
                    '1975-11-01',
                    '1975-11-02',
                    '1975-11-11',
                    '1975-11-15',
                    '1975-12-25',
                ],
            ],
            [
                1990,
                [
                    '1990-01-01',
                    '1990-01-06',
                    '1990-02-14',
                    '1990-04-15',
                    '1990-04-16',
                    '1990-05-01',
                    '1990-05-24',
                    '1990-06-03',
                    '1990-06-04',
                    '1990-07-11',
                    '1990-07-21',
                    '1990-08-15',
                    '1990-09-27',
                    '1990-10-31',
                    '1990-11-01',
                    '1990-11-02',
                    '1990-11-11',
                    '1990-11-15',
                    '1990-11-15',
                    '1990-12-25',
                ],
            ],
            [
                1998,
                [
                    '1998-01-01',
                    '1998-01-06',
                    '1998-02-14',
                    '1998-04-12',
                    '1998-04-13',
                    '1998-05-01',
                    '1998-05-21',
                    '1998-05-31',
                    '1998-06-01',
                    '1998-07-11',
                    '1998-07-21',
                    '1998-08-15',
                    '1998-09-20',
                    '1998-09-27',
                    '1998-10-31',
                    '1998-11-01',
                    '1998-11-02',
                    '1998-11-11',
                    '1998-11-15',
                    '1998-11-15',
                    '1998-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-06',
                    '2020-02-14',
                    '2020-04-12',
                    '2020-04-13',
                    '2020-05-01',
                    '2020-05-21',
                    '2020-05-31',
                    '2020-06-01',
                    '2020-07-11',
                    '2020-07-21',
                    '2020-08-15',
                    '2020-09-20',
                    '2020-09-27',
                    '2020-10-31',
                    '2020-11-01',
                    '2020-11-02',
                    '2020-11-11',
                    '2020-11-15',
                    '2020-11-15',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
