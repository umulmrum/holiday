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

use Umulmrum\Holiday\Provider\Germany\Hamburg;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class HamburgTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Hamburg::class,
        ];
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
                    '2019-04-19',
                    '2019-04-22',
                    '2019-05-01',
                    '2019-05-30',
                    '2019-06-09',
                    '2019-06-10',
                    '2019-10-03',
                    '2019-10-31',
                    '2019-11-20',
                    '2019-12-24',
                    '2019-12-25',
                    '2019-12-26',
                    '2019-12-31',
                ],
            ],
        ];
    }
}
