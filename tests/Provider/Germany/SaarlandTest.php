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

use Umulmrum\Holiday\Provider\Germany\Saarland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SaarlandTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Saarland::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2024,
                [
                    '2024-01-01',
                    '2024-03-29',
                    '2024-04-01',
                    '2024-05-01',
                    '2024-05-09',
                    '2024-05-19',
                    '2024-05-20',
                    '2024-05-30',
                    '2024-08-15',
                    '2024-10-03',
                    '2024-10-31',
                    '2024-11-01',
                    '2024-11-20',
                    '2024-12-24',
                    '2024-12-25',
                    '2024-12-26',
                    '2024-12-31',
                ],
            ],
        ];
    }
}
