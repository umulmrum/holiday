<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Switzerland;

use Umulmrum\Holiday\Provider\Switzerland\Neuchatel;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class NeuchatelTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Neuchatel::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1847,
                [
                    '1847-01-01',
                    '1847-01-02',
                    '1847-04-02',
                    '1847-04-05',
                    '1847-05-01',
                    '1847-05-13',
                    '1847-05-24',
                    '1847-06-03',
                    '1847-08-01',
                    '1847-09-05',
                    '1847-09-06',
                    '1847-12-25',
                ],
            ],
            [
                2016,
                [
                    '2016-01-01',
                    '2016-01-02',
                    '2016-03-01',
                    '2016-03-25',
                    '2016-03-28',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-16',
                    '2016-05-26',
                    '2016-08-01',
                    '2016-09-04',
                    '2016-09-05',
                    '2016-12-25',
                    '2016-12-26',
                ],
            ],
            [
                2017,
                [
                    '2017-01-01',
                    '2017-01-02',
                    '2017-03-01',
                    '2017-04-14',
                    '2017-04-17',
                    '2017-05-01',
                    '2017-05-25',
                    '2017-06-05',
                    '2017-06-15',
                    '2017-08-01',
                    '2017-09-03',
                    '2017-09-04',
                    '2017-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-02',
                    '2020-03-01',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-01',
                    '2020-05-21',
                    '2020-06-01',
                    '2020-06-11',
                    '2020-08-01',
                    '2020-09-06',
                    '2020-09-07',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
