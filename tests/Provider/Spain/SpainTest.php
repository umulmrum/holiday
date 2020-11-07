<?php

namespace Umulmrum\Holiday\Test\Provider\Spain;

use Umulmrum\Holiday\Provider\Spain\Spain;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class SpainTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Spain::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1892,
                [
                    '1892-01-01',
                    '1892-05-01',
                    '1892-10-12',
                    '1892-12-25',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-05-01',
                    '2020-10-12',
                    '2020-12-06',
                    '2020-12-25',
                ],
            ],
        ];
    }
}
