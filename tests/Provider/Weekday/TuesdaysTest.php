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

use Umulmrum\Holiday\Provider\Weekday\Tuesdays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class TuesdaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Tuesdays::class];
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
                    '2019-01-01',
                    '2019-01-08',
                    '2019-01-15',
                    '2019-01-22',
                    '2019-01-29',
                    '2019-02-05',
                    '2019-02-12',
                    '2019-02-19',
                    '2019-02-26',
                    '2019-03-05',
                    '2019-03-12',
                    '2019-03-19',
                    '2019-03-26',
                    '2019-04-02',
                    '2019-04-09',
                    '2019-04-16',
                    '2019-04-23',
                    '2019-04-30',
                    '2019-05-07',
                    '2019-05-14',
                    '2019-05-21',
                    '2019-05-28',
                    '2019-06-04',
                    '2019-06-11',
                    '2019-06-18',
                    '2019-06-25',
                    '2019-07-02',
                    '2019-07-09',
                    '2019-07-16',
                    '2019-07-23',
                    '2019-07-30',
                    '2019-08-06',
                    '2019-08-13',
                    '2019-08-20',
                    '2019-08-27',
                    '2019-09-03',
                    '2019-09-10',
                    '2019-09-17',
                    '2019-09-24',
                    '2019-10-01',
                    '2019-10-08',
                    '2019-10-15',
                    '2019-10-22',
                    '2019-10-29',
                    '2019-11-05',
                    '2019-11-12',
                    '2019-11-19',
                    '2019-11-26',
                    '2019-12-03',
                    '2019-12-10',
                    '2019-12-17',
                    '2019-12-24',
                    '2019-12-31',
                ],
            ],
        ];
    }
}
