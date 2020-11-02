<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Switzerland;

use Umulmrum\Holiday\Provider\Switzerland\Switzerland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SwitzerlandTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Switzerland::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1993,
                [
                    '1993-01-01',
                    '1993-05-20',
                    '1993-08-01',
                    '1993-09-05',
                    '1993-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-05-21',
                    '2020-08-01',
                    '2020-09-06',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
