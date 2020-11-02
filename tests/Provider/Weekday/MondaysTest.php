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

use Umulmrum\Holiday\Provider\Weekday\Mondays;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class MondaysTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Mondays::class];
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
                    '2019-01-07',
                    '2019-01-14',
                    '2019-01-21',
                    '2019-01-28',
                    '2019-02-04',
                    '2019-02-11',
                    '2019-02-18',
                    '2019-02-25',
                    '2019-03-04',
                    '2019-03-11',
                    '2019-03-18',
                    '2019-03-25',
                    '2019-04-01',
                    '2019-04-08',
                    '2019-04-15',
                    '2019-04-22',
                    '2019-04-29',
                    '2019-05-06',
                    '2019-05-13',
                    '2019-05-20',
                    '2019-05-27',
                    '2019-06-03',
                    '2019-06-10',
                    '2019-06-17',
                    '2019-06-24',
                    '2019-07-01',
                    '2019-07-08',
                    '2019-07-15',
                    '2019-07-22',
                    '2019-07-29',
                    '2019-08-05',
                    '2019-08-12',
                    '2019-08-19',
                    '2019-08-26',
                    '2019-09-02',
                    '2019-09-09',
                    '2019-09-16',
                    '2019-09-23',
                    '2019-09-30',
                    '2019-10-07',
                    '2019-10-14',
                    '2019-10-21',
                    '2019-10-28',
                    '2019-11-04',
                    '2019-11-11',
                    '2019-11-18',
                    '2019-11-25',
                    '2019-12-02',
                    '2019-12-09',
                    '2019-12-16',
                    '2019-12-23',
                    '2019-12-30',
                ],
            ],
        ];
    }
}
