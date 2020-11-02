<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Weekday;

use Umulmrum\Holiday\Provider\Weekday\Sundays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SundaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Sundays::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2019,
                [
                    '2019-01-06',
                    '2019-01-13',
                    '2019-01-20',
                    '2019-01-27',
                    '2019-02-03',
                    '2019-02-10',
                    '2019-02-17',
                    '2019-02-24',
                    '2019-03-03',
                    '2019-03-10',
                    '2019-03-17',
                    '2019-03-24',
                    '2019-03-31',
                    '2019-04-07',
                    '2019-04-14',
                    '2019-04-21',
                    '2019-04-28',
                    '2019-05-05',
                    '2019-05-12',
                    '2019-05-19',
                    '2019-05-26',
                    '2019-06-02',
                    '2019-06-09',
                    '2019-06-16',
                    '2019-06-23',
                    '2019-06-30',
                    '2019-07-07',
                    '2019-07-14',
                    '2019-07-21',
                    '2019-07-28',
                    '2019-08-04',
                    '2019-08-11',
                    '2019-08-18',
                    '2019-08-25',
                    '2019-09-01',
                    '2019-09-08',
                    '2019-09-15',
                    '2019-09-22',
                    '2019-09-29',
                    '2019-10-06',
                    '2019-10-13',
                    '2019-10-20',
                    '2019-10-27',
                    '2019-11-03',
                    '2019-11-10',
                    '2019-11-17',
                    '2019-11-24',
                    '2019-12-01',
                    '2019-12-08',
                    '2019-12-15',
                    '2019-12-22',
                    '2019-12-29',
                ],
            ],
        ];
    }
}
