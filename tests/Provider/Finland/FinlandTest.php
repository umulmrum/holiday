<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Finland;

use Umulmrum\Holiday\Provider\Finland\Finland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class FinlandTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [
            Finland::class,
        ];
    }

    public static function getData(): array
    {
        return [
            [
                1950,
                [
                    '1950-01-01',
                    '1950-01-06',
                    '1950-04-07',
                    '1950-04-09',
                    '1950-04-10',
                    '1950-05-01',
                    '1950-05-18',
                    '1950-05-28',
                    '1950-06-23',
                    '1950-06-24',
                    '1950-11-01',
                    '1950-12-06',
                    '1950-12-24',
                    '1950-12-25',
                    '1950-12-26',
                ],
            ],
            [
                1955,
                [
                    '1955-01-01',
                    '1955-01-06',
                    '1955-04-08',
                    '1955-04-10',
                    '1955-04-11',
                    '1955-05-01',
                    '1955-05-19',
                    '1955-05-29',
                    '1955-06-24',
                    '1955-06-25',
                    '1955-11-05',
                    '1955-12-06',
                    '1955-12-24',
                    '1955-12-25',
                    '1955-12-26',
                ],
            ],
            [
                1991,
                [
                    '1991-01-01',
                    '1991-01-12',
                    '1991-03-29',
                    '1991-03-31',
                    '1991-04-01',
                    '1991-05-01',
                    '1991-05-04',
                    '1991-05-19',
                    '1991-06-21',
                    '1991-06-22',
                    '1991-11-02',
                    '1991-12-06',
                    '1991-12-24',
                    '1991-12-25',
                    '1991-12-26',
                ],
            ],
            [
                2024,
                [
                    '2024-01-01',
                    '2024-01-06',
                    '2024-03-29',
                    '2024-03-31',
                    '2024-04-01',
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-19',
                    '2024-06-21',
                    '2024-06-22',
                    '2024-11-02',
                    '2024-12-06',
                    '2024-12-24',
                    '2024-12-25',
                    '2024-12-26',
                ],
            ],
        ];
    }
}
