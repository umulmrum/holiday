<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Denmark;

use Umulmrum\Holiday\Provider\Denmark\Denmark;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class DenmarkTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Denmark::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1848,
                [
                    '1848-01-01',
                    '1848-04-20',
                    '1848-04-21',
                    '1848-04-23',
                    '1848-04-24',
                    '1848-05-19',
                    '1848-06-01',
                    '1848-06-12',
                    '1848-08-15',
                    '1848-12-25',
                    '1848-12-26',
                    '1848-12-31',
                ],
            ],
            [
                1849,
                [
                    '1849-01-01',
                    '1849-04-05',
                    '1849-04-06',
                    '1849-04-08',
                    '1849-04-09',
                    '1849-05-04',
                    '1849-05-17',
                    '1849-05-28',
                    '1849-06-05',
                    '1849-08-15',
                    '1849-12-25',
                    '1849-12-26',
                    '1849-12-31',
                ],
            ],
            [
                1891,
                [
                    '1891-01-01',
                    '1891-03-26',
                    '1891-03-27',
                    '1891-03-29',
                    '1891-03-30',
                    '1891-04-24',
                    '1891-05-07',
                    '1891-05-18',
                    '1891-06-05',
                    '1891-08-15',
                    '1891-12-25',
                    '1891-12-26',
                    '1891-12-31',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-04-09',
                    '2020-04-10',
                    '2020-04-12',
                    '2020-04-13',
                    '2020-05-08',
                    '2020-05-21',
                    '2020-06-01',
                    '2020-06-05',
                    '2020-08-15',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-31',
                ],
            ],
        ];
    }
}
