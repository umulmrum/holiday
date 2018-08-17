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

use umulmrum\Holiday\Provider\Germany\SaxonyAnhalt;

class HolidayProviderSaxonyAnhaltTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            new SaxonyAnhalt(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2025,
                [
                    '2025-01-01',
                    '2025-01-06',
                    '2025-04-18',
                    '2025-04-20',
                    '2025-04-21',
                    '2025-05-01',
                    '2025-05-29',
                    '2025-06-08',
                    '2025-06-09',
                    '2025-10-03',
                    '2025-10-31',
                    '2025-11-19',
                    '2025-12-25',
                    '2025-12-26',
                ],
            ],
        ];
    }
}
