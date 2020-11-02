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

use Umulmrum\Holiday\Provider\Germany\Brandenburg;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class BrandenburgTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Brandenburg::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2018,
                [
                    '2018-01-01',
                    '2018-03-30',
                    '2018-04-01',
                    '2018-04-02',
                    '2018-05-01',
                    '2018-05-10',
                    '2018-05-20',
                    '2018-05-21',
                    '2018-10-03',
                    '2018-10-31',
                    '2018-11-21',
                    '2018-12-24',
                    '2018-12-25',
                    '2018-12-26',
                    '2018-12-31',
                ],
            ],
        ];
    }
}
