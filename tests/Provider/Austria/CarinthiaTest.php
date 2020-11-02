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

use Umulmrum\Holiday\Provider\Austria\Carinthia;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class CarinthiaTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Carinthia::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1920,
                [
                    '1920-01-01',
                    '1920-01-06',
                    '1920-03-19',
                    '1920-04-02',
                    '1920-04-04',
                    '1920-04-05',
                    '1920-05-01',
                    '1920-05-13',
                    '1920-05-23',
                    '1920-05-24',
                    '1920-08-15',
                    '1920-11-01',
                    '1920-11-12',
                    '1920-12-08',
                    '1920-12-24',
                    '1920-12-25',
                    '1920-12-26',
                    '1920-12-31',
                ],
            ],
            [
                1921,
                [
                    '1921-01-01',
                    '1921-01-06',
                    '1921-03-19',
                    '1921-03-25',
                    '1921-03-27',
                    '1921-03-28',
                    '1921-05-01',
                    '1921-05-05',
                    '1921-05-15',
                    '1921-05-16',
                    '1921-08-15',
                    '1921-10-26',
                    '1921-11-01',
                    '1921-11-12',
                    '1921-12-08',
                    '1921-12-24',
                    '1921-12-25',
                    '1921-12-26',
                    '1921-12-31',
                ],
            ],
        ];
    }
}
