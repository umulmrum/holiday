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

use Umulmrum\Holiday\Provider\Germany\Bavaria;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class BavariaTest extends AbstractHolidayCalculatorTest
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
                1968,
                [
                    '1968-01-01',
                    '1968-01-06',
                    '1968-03-19',
                    '1968-04-12',
                    '1968-04-15',
                    '1968-05-01',
                    '1968-05-23',
                    '1968-06-02',
                    '1968-06-03',
                    '1968-06-13',
                    '1968-06-17',
                    '1968-08-08',
                    '1968-08-15',
                    '1968-10-31',
                    '1968-11-01',
                    '1968-11-20',
                    '1968-12-24',
                    '1968-12-25',
                    '1968-12-26',
                    '1968-12-31',
                ],
            ],
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
