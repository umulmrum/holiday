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

use Umulmrum\Holiday\Provider\Germany\Saxony;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SaxonyTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Saxony::class,
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
                    '2016-03-25',
                    '2016-03-28',
                    '2016-05-01',
                    '2016-05-05',
                    '2016-05-15',
                    '2016-05-16',
                    '2016-05-26',
                    '2016-10-03',
                    '2016-10-31',
                    '2016-11-16',
                    '2016-12-24',
                    '2016-12-25',
                    '2016-12-26',
                    '2016-12-31',
                ],
            ],
            [
                2017,
                [
                    '2017-01-01',
                    '2017-04-14',
                    '2017-04-17',
                    '2017-05-01',
                    '2017-05-25',
                    '2017-06-04',
                    '2017-06-05',
                    '2017-06-15',
                    '2017-10-03',
                    '2017-10-31',
                    '2017-11-22',
                    '2017-12-24',
                    '2017-12-25',
                    '2017-12-26',
                    '2017-12-31',
                ],
            ],
        ];
    }
}
