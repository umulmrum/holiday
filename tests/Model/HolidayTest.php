<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Model;

use DateInterval;
use DateTime;
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
     * @param DateTime $dateTime
     */
    public function it_returns_the_correct_date(DateTime $dateTime)
    {
        $this->givenAHoliday($dateTime);
        $this->whenGetDateIsCalled();
        $this->thenThisDateShouldBeReturned($dateTime);
    }

    private function givenAHoliday(DateTime $dateTime)
    {
        $this->holiday = new Holiday('name', $dateTime);
    }

    private function whenGetDateIsCalled()
    {
        $this->actualResult = $this->holiday->getDate();
    }

    private function thenThisDateShouldBeReturned(DateTime $dateTime)
    {
        $this->assertEquals($dateTime, $this->actualResult);
    }

    /**
     * @test
     * @dataProvider getDateTimeData
     *
     * @param DateTime $dateTime
     */
    public function it_is_immutable(DateTime $dateTime)
    {
        $this->givenAHoliday($dateTime);
        $this->whenGetDateIsCalled();
        $this->whenTheResultIsModified();
        $this->whenGetDateIsCalled();
        $this->thenThisDateShouldBeReturned($dateTime);
    }

    private function whenTheResultIsModified()
    {
        $this->actualResult->add(new DateInterval('P1D'));
    }

    /**
     * @return array
     */
    public function getDateTimeData()
    {
        return [
            [
                new DateTime('1917-01-01'),
                new DateTime('1970-01-01'),
                new DateTime('2000-02-29'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                new DateTime('100-01-01'),
                100,
                1,
                1,
            ],
            [
                new DateTime('1917-01-01'),
                1917,
                1,
                1,
            ],
            [
                new DateTime('1970-01-01'),
                1970,
                1,
                1,
            ],
            [
                new DateTime('2000-02-29'),
                2000,
                2,
                29,
            ],
            [
                new DateTime('3100-05-23'),
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
    public function it_should_return_the_correct_name($name)
    {
        $this->givenANamedHoliday($name);
        $this->whenGetNameIsCalled();
        $this->thenTheCorrectNameShouldBeReturned($name);
    }

    /**
     * @param string $name
     */
    private function givenANamedHoliday($name)
    {
        $this->holiday = new Holiday($name, new DateTime('2001-04-12'));
    }

    private function whenGetNameIsCalled()
    {
        $this->actualResult = $this->holiday->getName();
    }

    /**
     * @param string $expectedResult
     */
    private function thenTheCorrectNameShouldBeReturned($expectedResult)
    {
        $this->assertEquals($expectedResult, $this->actualResult);
    }

    /**
     * @return array
     */
    public function getNameData()
    {
        return [
            ['name'],
        ];
    }
}
