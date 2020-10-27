<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Model;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Test\HolidayTestCase;

final class HolidayTest extends HolidayTestCase
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
     */
    public function it_returns_the_correct_date(string $date): void
    {
        $this->givenAHoliday($date);
        $this->whenGetDateIsCalled();
        $this->thenThisDateShouldBeReturned($date);
    }

    private function givenAHoliday(string $dateTime): void
    {
        $this->holiday = Holiday::create('name', $dateTime);
    }

    private function whenGetDateIsCalled(): void
    {
        $this->actualResult = $this->holiday->getDate();
    }

    private function thenThisDateShouldBeReturned(string $dateTime): void
    {
        self::assertEquals(new \DateTime($dateTime.' 00:00:00'), $this->actualResult);
    }

    /**
     * @test
     * @dataProvider getDateTimeData
     */
    public function it_is_immutable(string $dateTime): void
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
                '1917-01-01',
                '1970-01-01',
                '2000-02-29',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getNameData
     */
    public function it_should_return_the_correct_name(string $name): void
    {
        $this->givenANamedHoliday($name);
        $this->whenGetNameIsCalled();
        $this->thenTheCorrectNameShouldBeReturned($name);
    }

    private function givenANamedHoliday(string $name): void
    {
        $this->holiday = Holiday::create($name, '2001-04-12');
    }

    private function whenGetNameIsCalled(): void
    {
        $this->actualResult = $this->holiday->getName();
    }

    private function thenTheCorrectNameShouldBeReturned(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public function getNameData(): array
    {
        return [
            ['name'],
        ];
    }
}
