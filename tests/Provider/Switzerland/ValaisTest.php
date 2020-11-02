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

use Umulmrum\Holiday\Provider\Switzerland\Valais;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class ValaisTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [
            Valais::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                2020,
                [
                    '2020-01-01',
                    '2020-03-19',
                    '2020-05-21',
                    '2020-06-11',
                    '2020-08-01',
                    '2020-08-15',
                    '2020-09-06',
                    '2020-11-01',
                    '2020-12-08',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
