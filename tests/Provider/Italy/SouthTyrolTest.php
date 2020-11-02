<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Italy;

use Umulmrum\Holiday\Provider\Italy\SouthTyrol;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SouthTyrolTest extends AbstractHolidayCalculatorTest
{
    protected function getHolidayProviders(): array
    {
        return [SouthTyrol::class];
    }

    public function getData(): array
    {
        return [
            [
                2020,
                [
                    '2020-01-01',
                    '2020-01-05',
                    '2020-01-06',
                    '2020-01-07',
                    '2020-01-12',
                    '2020-01-19',
                    '2020-01-26',
                    '2020-01-27',
                    '2020-02-02',
                    '2020-02-09',
                    '2020-02-16',
                    '2020-02-23',
                    '2020-03-01',
                    '2020-03-08',
                    '2020-03-15',
                    '2020-03-22',
                    '2020-03-29',
                    '2020-04-05',
                    '2020-04-12',
                    '2020-04-12',
                    '2020-04-13',
                    '2020-04-19',
                    '2020-04-25',
                    '2020-04-26',
                    '2020-05-01',
                    '2020-05-03',
                    '2020-05-10',
                    '2020-05-17',
                    '2020-05-24',
                    '2020-05-31',
                    '2020-06-01',
                    '2020-06-02',
                    '2020-06-07',
                    '2020-06-14',
                    '2020-06-21',
                    '2020-06-28',
                    '2020-07-05',
                    '2020-07-12',
                    '2020-07-19',
                    '2020-07-26',
                    '2020-08-02',
                    '2020-08-09',
                    '2020-08-15',
                    '2020-08-16',
                    '2020-08-23',
                    '2020-08-30',
                    '2020-09-06',
                    '2020-09-13',
                    '2020-09-20',
                    '2020-09-27',
                    '2020-10-04',
                    '2020-10-11',
                    '2020-10-18',
                    '2020-10-25',
                    '2020-11-01',
                    '2020-11-01',
                    '2020-11-08',
                    '2020-11-15',
                    '2020-11-22',
                    '2020-11-29',
                    '2020-12-06',
                    '2020-12-08',
                    '2020-12-13',
                    '2020-12-20',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-27',
                ],
            ],
        ];
    }
}
