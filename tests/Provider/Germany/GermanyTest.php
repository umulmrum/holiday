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

use Umulmrum\Holiday\Provider\Germany\Germany;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class GermanyTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Germany::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1970,
                [
                    '1970-01-01',
                    '1970-03-27',
                    '1970-03-30',
                    '1970-05-01',
                    '1970-05-07',
                    '1970-05-17',
                    '1970-05-18',
                    '1970-06-17',
                    '1970-10-31',
                    '1970-11-18',
                    '1970-12-24',
                    '1970-12-25',
                    '1970-12-26',
                    '1970-12-31',
                ],
            ],
            [
                2019,
                [
                    '2019-01-01',
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
        ];
    }
}
