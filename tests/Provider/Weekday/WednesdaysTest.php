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

use Umulmrum\Holiday\Provider\Weekday\Wednesdays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class WednesdaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Wednesdays::class];
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
                    '2019-01-02',
                    '2019-01-09',
                    '2019-01-16',
                    '2019-01-23',
                    '2019-01-30',
                    '2019-02-06',
                    '2019-02-13',
                    '2019-02-20',
                    '2019-02-27',
                    '2019-03-06',
                    '2019-03-13',
                    '2019-03-20',
                    '2019-03-27',
                    '2019-04-03',
                    '2019-04-10',
                    '2019-04-17',
                    '2019-04-24',
                    '2019-05-01',
                    '2019-05-08',
                    '2019-05-15',
                    '2019-05-22',
                    '2019-05-29',
                    '2019-06-05',
                    '2019-06-12',
                    '2019-06-19',
                    '2019-06-26',
                    '2019-07-03',
                    '2019-07-10',
                    '2019-07-17',
                    '2019-07-24',
                    '2019-07-31',
                    '2019-08-07',
                    '2019-08-14',
                    '2019-08-21',
                    '2019-08-28',
                    '2019-09-04',
                    '2019-09-11',
                    '2019-09-18',
                    '2019-09-25',
                    '2019-10-02',
                    '2019-10-09',
                    '2019-10-16',
                    '2019-10-23',
                    '2019-10-30',
                    '2019-11-06',
                    '2019-11-13',
                    '2019-11-20',
                    '2019-11-27',
                    '2019-12-04',
                    '2019-12-11',
                    '2019-12-18',
                    '2019-12-25',
                ],
            ],
        ];
    }
}
