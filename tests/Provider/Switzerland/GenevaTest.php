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

use Umulmrum\Holiday\Provider\Switzerland\Geneva;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class GenevaTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Geneva::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1813,
                [
                    '1813-01-01',
                    '1813-01-02',
                    '1813-04-16',
                    '1813-04-19',
                    '1813-05-27',
                    '1813-06-07',
                    '1813-08-01',
                    '1813-09-05',
                    '1813-09-09',
                    '1813-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-02',
                    '2020-04-10',
                    '2020-04-13',
                    '2020-05-21',
                    '2020-06-01',
                    '2020-08-01',
                    '2020-09-06',
                    '2020-09-10',
                    '2020-12-25',
                    '2020-12-31',
                ],
            ],
        ];
    }
}
