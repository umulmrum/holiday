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

use Umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class BadenWuerttembergTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            BadenWuerttemberg::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2009,
                [
                    '2009-01-01',
                    '2009-01-06',
                    '2009-04-10',
                    '2009-04-13',
                    '2009-05-01',
                    '2009-05-21',
                    '2009-05-31',
                    '2009-06-01',
                    '2009-06-11',
                    '2009-10-03',
                    '2009-10-31',
                    '2009-11-01',
                    '2009-11-18',
                    '2009-12-24',
                    '2009-12-25',
                    '2009-12-26',
                    '2009-12-31',
                ],
            ],
            [
                2013,
                [
                    '2013-01-01',
                    '2013-01-06',
                    '2013-03-29',
                    '2013-04-01',
                    '2013-05-01',
                    '2013-05-09',
                    '2013-05-19',
                    '2013-05-20',
                    '2013-05-30',
                    '2013-10-03',
                    '2013-10-31',
                    '2013-11-01',
                    '2013-11-20',
                    '2013-12-24',
                    '2013-12-25',
                    '2013-12-26',
                    '2013-12-31',
                ],
            ],
            [
                2016,
                [
                    '2016-01-01',
                    '2016-01-06',
                    '2016-03-25',
                    '2016-03-28',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-15',
                    '2016-05-16',
                    '2016-05-26',
                    '2016-10-03',
                    '2016-10-31',
                    '2016-11-01',
                    '2016-11-16',
                    '2016-12-24',
                    '2016-12-25',
                    '2016-12-26',
                    '2016-12-31',
                ],
            ],
        ];
    }
}
