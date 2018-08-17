<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\Provider\Germany\NorthRhineWestphalia;

class HolidayProviderNorthrineWestphaliaTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            new NorthRhineWestphalia(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2022,
                [
                    '2022-01-01',
                    '2022-04-15',
                    '2022-04-17',
                    '2022-04-18',
                    '2022-05-01',
                    '2022-05-26',
                    '2022-06-05',
                    '2022-06-06',
                    '2022-06-16',
                    '2022-10-03',
                    '2022-10-31',
                    '2022-11-01',
                    '2022-11-16',
                    '2022-12-25',
                    '2022-12-26',
                ],
            ],
        ];
    }
}
