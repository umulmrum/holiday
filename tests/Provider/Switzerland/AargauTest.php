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

use Umulmrum\Holiday\Provider\Switzerland\Aargau;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class AargauTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Aargau::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2017,
                [
                    '2017-01-01',
                    '2017-01-02',
                    '2017-04-14',
                    '2017-04-17',
                    '2017-05-01',
                    '2017-05-25',
                    '2017-06-05',
                    '2017-06-15',
                    '2017-08-01',
                    '2017-08-15',
                    '2017-09-03',
                    '2017-11-01',
                    '2017-12-08',
                    '2017-12-25',
                    '2017-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-02',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-01',
                    '2020-05-21',
                    '2020-06-01',
                    '2020-06-11',
                    '2020-08-01',
                    '2020-08-15',
                    '2020-09-06',
                    '2020-11-01',
                    '2020-12-08',
                    '2020-12-25',
                    '2020-12-26',
                ],
            ],
        ];
    }
}
