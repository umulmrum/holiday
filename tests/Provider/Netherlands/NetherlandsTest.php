<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Netherlands;

use Umulmrum\Holiday\Provider\Netherlands\Netherlands;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class NetherlandsTest extends AbstractHolidayCalculatorTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Netherlands::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getData(): array
    {
        return [
            [
                1948,
                [
                    '1948-01-01',
                    '1948-03-26',
                    '1948-03-28',
                    '1948-03-29',
                    '1948-05-05',
                    '1948-05-06',
                    '1948-05-16',
                    '1948-05-17',
                    '1948-08-31',
                    '1948-12-25',
                    '1948-12-26',
                ],
            ],
            [
                1963,
                [
                    '1963-01-01',
                    '1963-04-12',
                    '1963-04-14',
                    '1963-04-15',
                    '1963-04-30',
                    '1963-05-06',
                    '1963-05-23',
                    '1963-06-02',
                    '1963-06-03',
                    '1963-12-25',
                    '1963-12-26',
                ],
            ],
            [
                1967,
                [
                    '1967-01-01',
                    '1967-03-24',
                    '1967-03-26',
                    '1967-03-27',
                    '1967-05-01',
                    '1967-05-04',
                    '1967-05-05',
                    '1967-05-14',
                    '1967-05-15',
                    '1967-12-25',
                    '1967-12-26',
                ],
            ],
            [
                1975,
                [
                    '1975-01-01',
                    '1975-03-28',
                    '1975-03-30',
                    '1975-03-31',
                    '1975-04-30',
                    '1975-05-05',
                    '1975-05-08',
                    '1975-05-18',
                    '1975-05-19',
                    '1975-12-25',
                    '1975-12-26',
                ],
            ],
            [
                1989,
                [
                    '1989-01-01',
                    '1989-03-24',
                    '1989-03-26',
                    '1989-03-27',
                    '1989-04-29',
                    '1989-05-04',
                    '1989-05-14',
                    '1989-05-15',
                    '1989-12-25',
                    '1989-12-26',
                ],
            ],
            [
                1990,
                [
                    '1990-01-01',
                    '1990-04-13',
                    '1990-04-15',
                    '1990-04-16',
                    '1990-04-30',
                    '1990-05-05',
                    '1990-05-24',
                    '1990-06-03',
                    '1990-06-04',
                    '1990-12-25',
                    '1990-12-26',
                ],
            ],
            [
                2014,
                [
                    '2014-01-01',
                    '2014-04-18',
                    '2014-04-20',
                    '2014-04-21',
                    '2014-04-26',
                    '2014-05-05',
                    '2014-05-29',
                    '2014-06-08',
                    '2014-06-09',
                    '2014-12-25',
                    '2014-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-04-10',
                    '2020-04-12',
                    '2020-04-13',
                    '2020-04-27',
                    '2020-05-05',
                    '2020-05-21',
                    '2020-05-31',
                    '2020-06-01',
                    '2020-12-25',
                    '2020-12-26',
                ],
            ],
        ];
    }
}
