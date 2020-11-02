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

use Umulmrum\Holiday\Provider\Weekday\Fridays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class FridaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Fridays::class];
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
                    '2019-01-04',
                    '2019-01-11',
                    '2019-01-18',
                    '2019-01-25',
                    '2019-02-01',
                    '2019-02-08',
                    '2019-02-15',
                    '2019-02-22',
                    '2019-03-01',
                    '2019-03-08',
                    '2019-03-15',
                    '2019-03-22',
                    '2019-03-29',
                    '2019-04-05',
                    '2019-04-12',
                    '2019-04-19',
                    '2019-04-26',
                    '2019-05-03',
                    '2019-05-10',
                    '2019-05-17',
                    '2019-05-24',
                    '2019-05-31',
                    '2019-06-07',
                    '2019-06-14',
                    '2019-06-21',
                    '2019-06-28',
                    '2019-07-05',
                    '2019-07-12',
                    '2019-07-19',
                    '2019-07-26',
                    '2019-08-02',
                    '2019-08-09',
                    '2019-08-16',
                    '2019-08-23',
                    '2019-08-30',
                    '2019-09-06',
                    '2019-09-13',
                    '2019-09-20',
                    '2019-09-27',
                    '2019-10-04',
                    '2019-10-11',
                    '2019-10-18',
                    '2019-10-25',
                    '2019-11-01',
                    '2019-11-08',
                    '2019-11-15',
                    '2019-11-22',
                    '2019-11-29',
                    '2019-12-06',
                    '2019-12-13',
                    '2019-12-20',
                    '2019-12-27',
                ],
            ],
        ];
    }
}
