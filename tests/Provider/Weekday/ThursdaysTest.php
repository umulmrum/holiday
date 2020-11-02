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

use Umulmrum\Holiday\Provider\Weekday\Thursdays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class ThursdaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Thursdays::class];
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
                    '2019-01-03',
                    '2019-01-10',
                    '2019-01-17',
                    '2019-01-24',
                    '2019-01-31',
                    '2019-02-07',
                    '2019-02-14',
                    '2019-02-21',
                    '2019-02-28',
                    '2019-03-07',
                    '2019-03-14',
                    '2019-03-21',
                    '2019-03-28',
                    '2019-04-04',
                    '2019-04-11',
                    '2019-04-18',
                    '2019-04-25',
                    '2019-05-02',
                    '2019-05-09',
                    '2019-05-16',
                    '2019-05-23',
                    '2019-05-30',
                    '2019-06-06',
                    '2019-06-13',
                    '2019-06-20',
                    '2019-06-27',
                    '2019-07-04',
                    '2019-07-11',
                    '2019-07-18',
                    '2019-07-25',
                    '2019-08-01',
                    '2019-08-08',
                    '2019-08-15',
                    '2019-08-22',
                    '2019-08-29',
                    '2019-09-05',
                    '2019-09-12',
                    '2019-09-19',
                    '2019-09-26',
                    '2019-10-03',
                    '2019-10-10',
                    '2019-10-17',
                    '2019-10-24',
                    '2019-10-31',
                    '2019-11-07',
                    '2019-11-14',
                    '2019-11-21',
                    '2019-11-28',
                    '2019-12-05',
                    '2019-12-12',
                    '2019-12-19',
                    '2019-12-26',
                ],
            ],
        ];
    }
}
