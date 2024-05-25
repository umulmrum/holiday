<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Provider\Turkey;

use Umulmrum\Holiday\Provider\Turkey\Turkey;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTestCase;

final class TurkeyTest extends AbstractHolidayCalculatorTestCase
{
    protected function getHolidayProviders(): array
    {
        return [Turkey::class];
    }

    public static function getData(): array
    {
        return [
            [
                1962,
                [
                    '1962-01-01',
                    '1962-04-23',
                    '1962-05-01',
                    '1962-05-19',
                    '1962-08-30',
                    '1962-10-28',
                    '1962-10-29',
                ],
            ],
            [
                1963,
                [
                    '1963-01-01',
                    '1963-04-23',
                    '1963-05-01',
                    '1963-05-19',
                    '1963-05-27',
                    '1963-08-30',
                    '1963-10-28',
                    '1963-10-29',
                ],
            ],
            [
                1981,
                [
                    '1981-01-01',
                    '1981-04-23',
                    '1981-05-01',
                    '1981-05-19',
                    '1981-05-27',
                    '1981-08-30',
                    '1981-10-28',
                    '1981-10-29',
                ],
            ],
            [
                2016,
                [
                    '2016-01-01',
                    '2016-04-23',
                    '2016-05-01',
                    '2016-05-19',
                    '2016-08-30',
                    '2016-10-28',
                    '2016-10-29',
                ],
            ],
            [
                2017,
                [
                    '2017-01-01',
                    '2017-04-23',
                    '2017-05-01',
                    '2017-05-19',
                    '2017-07-15',
                    '2017-08-30',
                    '2017-10-28',
                    '2017-10-29',
                ],
            ],
            [
                2024,
                [
                    '2024-01-01',
                    '2024-04-23',
                    '2024-05-01',
                    '2024-05-19',
                    '2024-07-15',
                    '2024-08-30',
                    '2024-10-28',
                    '2024-10-29',
                ],
            ],
        ];
    }
}
