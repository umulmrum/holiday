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

use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SaturdaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Saturdays::class];
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
                    '2019-01-05',
                    '2019-01-12',
                    '2019-01-19',
                    '2019-01-26',
                    '2019-02-02',
                    '2019-02-09',
                    '2019-02-16',
                    '2019-02-23',
                    '2019-03-02',
                    '2019-03-09',
                    '2019-03-16',
                    '2019-03-23',
                    '2019-03-30',
                    '2019-04-06',
                    '2019-04-13',
                    '2019-04-20',
                    '2019-04-27',
                    '2019-05-04',
                    '2019-05-11',
                    '2019-05-18',
                    '2019-05-25',
                    '2019-06-01',
                    '2019-06-08',
                    '2019-06-15',
                    '2019-06-22',
                    '2019-06-29',
                    '2019-07-06',
                    '2019-07-13',
                    '2019-07-20',
                    '2019-07-27',
                    '2019-08-03',
                    '2019-08-10',
                    '2019-08-17',
                    '2019-08-24',
                    '2019-08-31',
                    '2019-09-07',
                    '2019-09-14',
                    '2019-09-21',
                    '2019-09-28',
                    '2019-10-05',
                    '2019-10-12',
                    '2019-10-19',
                    '2019-10-26',
                    '2019-11-02',
                    '2019-11-09',
                    '2019-11-16',
                    '2019-11-23',
                    '2019-11-30',
                    '2019-12-07',
                    '2019-12-14',
                    '2019-12-21',
                    '2019-12-28',
                ],
            ],
        ];
    }
}
