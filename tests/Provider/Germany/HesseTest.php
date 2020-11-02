<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Germany;

use Umulmrum\Holiday\Provider\Germany\Hesse;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class HesseTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Hesse::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2016,
                [
                    '2016-01-01',
                    '2016-01-03',
                    '2016-01-10',
                    '2016-01-17',
                    '2016-01-24',
                    '2016-01-31',
                    '2016-02-07',
                    '2016-02-14',
                    '2016-02-21',
                    '2016-02-28',
                    '2016-03-06',
                    '2016-03-13',
                    '2016-03-20',
                    '2016-03-25',
                    '2016-03-27',
                    '2016-03-28',
                    '2016-04-03',
                    '2016-04-10',
                    '2016-04-17',
                    '2016-04-24',
                    '2016-05-01',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-08',
                    '2016-05-15',
                    '2016-05-15',
                    '2016-05-16',
                    '2016-05-22',
                    '2016-05-26',
                    '2016-05-29',
                    '2016-06-05',
                    '2016-06-12',
                    '2016-06-19',
                    '2016-06-26',
                    '2016-07-03',
                    '2016-07-10',
                    '2016-07-17',
                    '2016-07-24',
                    '2016-07-31',
                    '2016-08-07',
                    '2016-08-14',
                    '2016-08-21',
                    '2016-08-28',
                    '2016-09-04',
                    '2016-09-11',
                    '2016-09-18',
                    '2016-09-25',
                    '2016-10-02',
                    '2016-10-03',
                    '2016-10-09',
                    '2016-10-16',
                    '2016-10-23',
                    '2016-10-30',
                    '2016-10-31',
                    '2016-11-06',
                    '2016-11-13',
                    '2016-11-16',
                    '2016-11-20',
                    '2016-11-27',
                    '2016-12-04',
                    '2016-12-11',
                    '2016-12-18',
                    '2016-12-24',
                    '2016-12-25',
                    '2016-12-25',
                    '2016-12-26',
                    '2016-12-31',
                ],
            ],
        ];
    }
}
