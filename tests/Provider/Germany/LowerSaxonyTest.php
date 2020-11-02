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

use Umulmrum\Holiday\Provider\Germany\LowerSaxony;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class LowerSaxonyTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            LowerSaxony::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2021,
                [
                    '2021-01-01',
                    '2021-04-02',
                    '2021-04-05',
                    '2021-05-01',
                    '2021-05-13',
                    '2021-05-23',
                    '2021-05-24',
                    '2021-10-03',
                    '2021-10-31',
                    '2021-11-17',
                    '2021-12-24',
                    '2021-12-25',
                    '2021-12-26',
                    '2021-12-31',
                ],
            ],
        ];
    }
}
