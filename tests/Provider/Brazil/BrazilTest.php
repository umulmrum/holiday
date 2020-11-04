<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Brazil;

use Umulmrum\Holiday\Provider\Brazil\Brazil;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class BrazilTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Brazil::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1889,
                [
                    '1889-01-01',
                    '1889-03-05',
                    '1889-03-06',
                    '1889-04-19',
                    '1889-04-21',
                    '1889-05-01',
                    '1889-10-12',
                    '1889-11-02',
                    '1889-12-25',
                ],
            ],
            [
                1890,
                [
                    '1890-01-01',
                    '1890-02-18',
                    '1890-02-19',
                    '1890-04-04',
                    '1890-04-21',
                    '1890-05-01',
                    '1890-10-05',
                    '1890-10-12',
                    '1890-10-26',
                    '1890-11-02',
                    '1890-11-15',
                    '1890-12-25',
                ],
            ],
            [
                1949,
                [
                    '1949-01-01',
                    '1949-03-01',
                    '1949-03-02',
                    '1949-04-15',
                    '1949-04-21',
                    '1949-05-01',
                    '1949-09-07',
                    '1949-10-12',
                    '1949-11-02',
                    '1949-11-15',
                    '1949-12-25',
                ],
            ],
            [
                1980,
                [
                    '1980-01-01',
                    '1980-02-19',
                    '1980-02-20',
                    '1980-04-04',
                    '1980-04-21',
                    '1980-05-01',
                    '1980-09-07',
                    '1980-10-05',
                    '1980-10-12',
                    '1980-10-26',
                    '1980-11-02',
                    '1980-11-15',
                    '1980-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-02-25',
                    '2020-02-26',
                    '2020-04-10',
                    '2020-04-21',
                    '2020-05-01',
                    '2020-09-07',
                    '2020-10-04',
                    '2020-10-12',
                    '2020-10-25',
                    '2020-11-02',
                    '2020-11-15',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
