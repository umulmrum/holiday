<?php

namespace Umulmrum\Holiday\Test\Provider\Ireland;

use Umulmrum\Holiday\Provider\Ireland\Ireland;
use Umulmrum\Holiday\Test\Calculator\AbstractHolidayCalculatorTest;

final class IrelandTest extends AbstractHolidayCalculatorTest
{
    /**
     * {@inheritdoc}
     */
    protected function getHolidayProviders(): array
    {
        return [Ireland::class];
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            [
                1870,
                [
                    '1870-01-01',
                    '1870-01-03',
                    '1870-04-15',
                    '1870-06-06',
                    '1870-12-25',
                    '1870-12-26',
                    '1870-12-27',
                ],
            ],
            [
                1902,
                [
                    '1902-01-01',
                    '1902-03-28',
                    '1902-05-19',
                    '1902-08-04',
                    '1902-12-25',
                    '1902-12-26',
                ],
            ],
            [
                1974,
                [
                    '1974-01-01',
                    '1974-03-17',
                    '1974-03-18',
                    '1974-04-12',
                    '1974-06-03',
                    '1974-08-05',
                    '1974-12-25',
                    '1974-12-26',
                ],
            ],
            [
                2011,
                [
                    '2011-01-01',
                    '2011-01-03', // due to 2011-01-01 on Saturday
                    '2011-03-17',
                    '2011-04-22',
                    '2011-05-02',
                    '2011-06-06',
                    '2011-08-01',
                    '2011-10-31',
                    '2011-12-25',
                    '2011-12-26',
                    '2011-12-27', // due to 2011-12-25 on Sunday
                ],
            ],
            [
                2019,
                [
                    '2019-01-01',
                    '2019-03-17',
                    '2019-03-18', // due to 2019-03-17 on Sunday
                    '2019-04-19',
                    '2019-05-06',
                    '2019-06-03',
                    '2019-08-05',
                    '2019-10-28',
                    '2019-12-25',
                    '2019-12-26',
                ],
            ],
            [
                2020,
                [
                    '2020-01-01',
                    '2020-03-17',
                    '2020-04-10',
                    '2020-05-04',
                    '2020-06-01',
                    '2020-08-03',
                    '2020-10-26',
                    '2020-12-25',
                    '2020-12-26',
                    '2020-12-28', // due to 2020-12-26 on Saturday
                ],
            ],
        ];
    }
}
