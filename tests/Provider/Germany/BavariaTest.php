<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Germany;

use umulmrum\Holiday\Calculator\AbstractHolidayCalculatorTest;

class BavariaTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Bavaria::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2016,
                [
                    '2016-01-01',
                    '2016-01-06',
                    '2016-03-25',
                    '2016-03-28',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-15',
                    '2016-05-16',
                    '2016-05-26',
                    '2016-08-08',
                    '2016-08-15',
                    '2016-10-03',
                    '2016-10-31',
                    '2016-11-01',
                    '2016-11-16',
                    '2016-12-24',
                    '2016-12-25',
                    '2016-12-26',
                    '2016-12-31',
                ],
            ],
        ];
    }
}
