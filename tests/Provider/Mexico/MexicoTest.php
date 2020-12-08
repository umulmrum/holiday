<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\Mexico;

use Umulmrum\Holiday\Provider\Mexico\Mexico;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class MexicoTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Mexico::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1825,
                [
                    '1825-01-01',
                    '1825-02-04',
                    '1825-02-05',
                    '1825-12-25',
                    '1825-12-26',
                ],
            ],
            [
                1826,
                [
                    '1826-01-01',
                    '1826-01-02',
                    '1826-02-05',
                    '1826-02-06',
                    '1826-09-15',
                    '1826-09-16',
                    '1826-12-25',
                ],
            ],
            [
                1911,
                [
                    '1911-01-01',
                    '1911-01-02',
                    '1911-02-05',
                    '1911-02-06',
                    '1911-09-15',
                    '1911-09-16',
                    '1911-11-20',
                    '1911-12-25',
                ],
            ],
            [
                1918,
                [
                    '1918-01-01',
                    '1918-02-05',
                    '1918-02-05',
                    '1918-09-16',
                    '1918-11-20',
                    '1918-12-25',
                ],
            ],
            [
                1923,
                [
                    '1923-01-01',
                    '1923-02-05',
                    '1923-02-05',
                    '1923-05-01',
                    '1923-09-16',
                    '1923-09-17',
                    '1923-11-20',
                    '1923-12-25',
                ],
            ],
            [
                2006,
                [
                    '2006-01-01',
                    '2006-01-02',
                    '2006-02-06',
                    '2006-03-20',
                    '2006-05-01',
                    '2006-09-15',
                    '2006-09-16',
                    '2006-11-20',
                    '2006-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-02-03',
                    '2020-03-16',
                    '2020-05-01',
                    '2020-09-16',
                    '2020-11-16',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
