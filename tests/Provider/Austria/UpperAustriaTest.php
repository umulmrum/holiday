<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Austria;

use Umulmrum\Holiday\Provider\Austria\UpperAustria;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class UpperAustriaTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [UpperAustria::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2003,
                [
                    '2003-01-01',
                    '2003-01-06',
                    '2003-04-18',
                    '2003-04-20',
                    '2003-04-21',
                    '2003-05-01',
                    '2003-05-29',
                    '2003-06-08',
                    '2003-06-09',
                    '2003-08-15',
                    '2003-10-26',
                    '2003-11-01',
                    '2003-11-15',
                    '2003-12-08',
                    '2003-12-24',
                    '2003-12-25',
                    '2003-12-26',
                    '2003-12-31',
                ],
            ],
            [
                2004,
                [
                    '2004-01-01',
                    '2004-01-06',
                    '2004-04-09',
                    '2004-04-11',
                    '2004-04-12',
                    '2004-05-01',
                    '2004-05-04',
                    '2004-05-20',
                    '2004-05-30',
                    '2004-05-31',
                    '2004-08-15',
                    '2004-10-26',
                    '2004-11-01',
                    '2004-12-08',
                    '2004-12-24',
                    '2004-12-25',
                    '2004-12-26',
                    '2004-12-31',
                ],
            ],
        ];
    }
}
