<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Model;

use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;

class HolidayTest extends HolidayTestCase
{
    /**
     * @var Holiday
     */
    private $holiday;
    /**
     * @var
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getDateTimeData
     *
     * @param \DateTime $dateTime
     */
    public function it_returns_the_correct_date(\DateTime $dateTime): void
    {
        $this->givenAHoliday($dateTime);
        $this->whenGetDateIsCalled();
        $this->thenThisDateShouldBeReturned($dateTime);
    }

    private function givenAHoliday(\DateTime $dateTime): void
    {
        $this->holiday = new Holiday('name', $dateTime);
    }

    private function whenGetDateIsCalled(): void
    {
        $this->actualResult = $this->holiday->getDate();
    }

    private function thenThisDateShouldBeReturned(\DateTime $dateTime): void
    {
        $this->assertEquals($dateTime, $this->actualResult);
    }

    /**
     * @test
     * @dataProvider getDateTimeData
     *
     * @param \DateTime $dateTime
     */
    public function it_is_immutable(\DateTime $dateTime): void
    {
        $this->givenAHoliday($dateTime);
        $this->whenGetDateIsCalled();
        $this->whenTheResultIsModified();
        $this->whenGetDateIsCalled();
        $this->thenThisDateShouldBeReturned($dateTime);
    }

    private function whenTheResultIsModified(): void
    {
        $this->actualResult->add(new \DateInterval('P1D'));
    }

    public function getDateTimeData(): array
    {
        return [
            [
                new \DateTime('1917-01-01'),
                new \DateTime('1970-01-01'),
                new \DateTime('2000-02-29'),
            ],
        ];
    }

    public function getData(): array
    {
        return [
            [
                new \DateTime('100-01-01'),
                100,
                1,
                1,
            ],
            [
                new \DateTime('1917-01-01'),
                1917,
                1,
                1,
            ],
            [
                new \DateTime('1970-01-01'),
                1970,
                1,
                1,
            ],
            [
                new \DateTime('2000-02-29'),
                2000,
                2,
                29,
            ],
            [
                new \DateTime('3100-05-23'),
                3100,
                5,
                23,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getNameData
     *
     * @param string $name
     */
    public function it_should_return_the_correct_name(string $name): void
    {
        $this->givenANamedHoliday($name);
        $this->whenGetNameIsCalled();
        $this->thenTheCorrectNameShouldBeReturned($name);
    }

    private function givenANamedHoliday(string $name): void
    {
        $this->holiday = new Holiday($name, new \DateTime('2001-04-12'));
    }

    private function whenGetNameIsCalled(): void
    {
        $this->actualResult = $this->holiday->getName();
    }

    private function thenTheCorrectNameShouldBeReturned(string $expectedResult): void
    {
        $this->assertEquals($expectedResult, $this->actualResult);
    }

    public function getNameData(): array
    {
        return [
            ['name'],
        ];
    }
}
