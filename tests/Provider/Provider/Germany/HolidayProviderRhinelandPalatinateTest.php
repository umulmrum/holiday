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

use umulmrum\Holiday\Provider\Germany\RhinelandPalatinate;

class HolidayProviderRhinelandPalatinateTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            RhinelandPalatinate::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2023,
                [
                    '2023-01-01',
                    '2023-04-07',
                    '2023-04-09',
                    '2023-04-10',
                    '2023-05-01',
                    '2023-05-18',
                    '2023-05-28',
                    '2023-05-29',
                    '2023-06-08',
                    '2023-10-03',
                    '2023-10-31',
                    '2023-11-01',
                    '2023-11-22',
                    '2023-12-25',
                    '2023-12-26',
                ],
            ],
        ];
    }
}
