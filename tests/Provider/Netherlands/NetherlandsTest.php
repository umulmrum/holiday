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
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class NetherlandsTest extends AbstractHolidayCalculatorTest
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
    public function getData(): array
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
                    '1948-12-26'
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
                    '1975-12-26'
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
                    '1990-12-26'
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
                    '2020-12-26'
                ],
            ],
        ];
    }
}
