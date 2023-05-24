<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider\UK;

use Umulmrum\Holiday\Provider\Poland\Poland;
use Umulmrum\Holiday\Provider\UK\England;
use Umulmrum\Holiday\Provider\UK\UnitedKingdom;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class EnglandTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [England::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1980,
                [
                    '1980-01-01',
                    '1980-04-04',
                    '1980-04-07',
                    '1980-05-26',
                    '1980-08-25',
                    '1980-12-25',
                    '1980-12-26'
                ],
            ],
            [
                2022,
                [
                    '2022-01-01',
                    '2022-04-15',
                    '2022-04-18',
                    '2022-05-02',
                    '2022-05-30',
                    '2022-08-29',
                    '2022-12-25',
                    '2022-12-26'
                ],
            ],
        ];
    }
}
