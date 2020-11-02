<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Germany;

use Umulmrum\Holiday\Provider\Germany\Berlin;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class BerlinTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Berlin::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2018,
                [
                    '2018-01-01',
                    '2018-03-30',
                    '2018-04-02',
                    '2018-05-01',
                    '2018-05-10',
                    '2018-05-20',
                    '2018-05-21',
                    '2018-10-03',
                    '2018-10-31',
                    '2018-11-21',
                    '2018-12-24',
                    '2018-12-25',
                    '2018-12-26',
                    '2018-12-31',
                ],
            ],
            [
                2019,
                [
                    '2019-01-01',
                    '2019-03-08',
                    '2019-04-19',
                    '2019-04-22',
                    '2019-05-01',
                    '2019-05-30',
                    '2019-06-09',
                    '2019-06-10',
                    '2019-10-03',
                    '2019-10-31',
                    '2019-11-20',
                    '2019-12-24',
                    '2019-12-25',
                    '2019-12-26',
                    '2019-12-31',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-03-08',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-01',
                    '2020-05-08',
                    '2020-05-21',
                    '2020-05-31',
                    '2020-06-01',
                    '2020-10-03',
                    '2020-10-31',
                    '2020-11-18',
                    '2020-12-24',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-31',
                ],
            ],
        ];
    }
}
