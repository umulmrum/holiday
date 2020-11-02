<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Luxembourg;

use Umulmrum\Holiday\Provider\Luxembourg\Luxembourg;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class LuxembourgTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Luxembourg::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1961,
                [
                    '1961-01-01',
                    '1961-03-31',
                    '1961-04-03',
                    '1961-05-11',
                    '1961-05-22',
                    '1961-05-23',
                    '1961-08-15',
                    '1961-11-01',
                    '1961-12-25',
                    '1961-12-26',
                ],
            ],
            [
                2018,
                [
                    '2018-01-01',
                    '2018-03-30',
                    '2018-04-02',
                    '2018-05-10',
                    '2018-05-21',
                    '2018-05-22',
                    '2018-06-23',
                    '2018-08-15',
                    '2018-11-01',
                    '2018-12-25',
                    '2018-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-09',
                    '2020-05-21',
                    '2020-06-01',
                    '2020-06-02',
                    '2020-06-23',
                    '2020-08-15',
                    '2020-11-01',
                    '2020-12-25',
                    '2020-12-26',
                ],
            ],
        ];
    }
}
