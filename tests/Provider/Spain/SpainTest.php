<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Spain;

use Umulmrum\Holiday\Provider\Spain\Spain;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SpainTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Spain::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1892,
                [
                    '1892-01-01',
                    '1892-01-06',
                    '1892-04-14',
                    '1892-04-15',
                    '1892-05-01',
                    '1892-08-15',
                    '1892-10-12',
                    '1892-11-01',
                    '1892-12-25',
                ],
            ],
            [
                1940,
                [
                    '1940-01-01',
                    '1940-01-06',
                    '1940-03-21',
                    '1940-03-22',
                    '1940-08-15',
                    '1940-10-12',
                    '1940-11-01',
                    '1940-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-06',
                    '2020-04-09',
                    '2020-04-10',
                    '2020-05-01',
                    '2020-08-15',
                    '2020-10-12',
                    '2020-11-01',
                    '2020-12-06',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
