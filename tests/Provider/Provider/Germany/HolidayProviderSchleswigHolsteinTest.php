<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\Provider\Germany\Germany;
use umulmrum\Holiday\Provider\Germany\SchleswigHolstein;
use umulmrum\Holiday\Provider\Germany\Thuringia;

class HolidayProviderSchleswigHolsteinTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            new SchleswigHolstein(),
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
                    '2019-04-21',
                    '2019-04-22',
                    '2019-05-01',
                    '2019-05-30',
                    '2019-06-09',
                    '2019-06-10',
                    '2019-10-03',
                    '2019-10-31',
                    '2019-11-20',
                    '2019-12-25',
                    '2019-12-26',
                ],
            ],
        ];
    }
}
