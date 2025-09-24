<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Model;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Test\FormatterStub;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class HolidayTest extends HolidayTestCase
{
    private Holiday $holiday;
    private mixed $actualResult;

    #[DataProvider('getDateTimeData')]
    #[Test]
    public function itBuildsCorrectlyFromConstructor(string $name, string $date, int $type): void
    {
        $this->whenHolidayIsCreatedFromConstructor($name, $date, $type);
        $this->thenThisNameShouldBeSet($name);
        $this->thenThisSimpleDateShouldBeSet($date);
        $this->thenThisTypeShouldBeSet($type);
    }

    private function whenHolidayIsCreatedFromConstructor(string $name, string $date, int $type): void
    {
        $this->holiday = new Holiday($name, $date, $type);
    }

    private function thenThisNameShouldBeSet(string $name): void
    {
        self::assertEquals($name, $this->holiday->getName());
    }

    private function thenThisSimpleDateShouldBeSet(string $dateTime): void
    {
        self::assertEquals($dateTime, $this->holiday->getSimpleDate());
    }

    private function thenThisTypeShouldBeSet(int $type): void
    {
        self::assertEquals($type, $this->holiday->getType());
    }

    #[DataProvider('provideDataForInvalidConstructorData')]
    #[Test]
    public function itFailsOnInvalidConstructorData(string $name, string $date, int $type): void
    {
        $this->thenInvalidArgumentExceptionShouldBeThrown();
        $this->whenHolidayIsCreatedFromConstructor($name, $date, $type);
    }

    public static function provideDataForInvalidConstructorData(): array
    {
        return [
            'empty-name' => [
                '',
                '2024-01-01',
                HolidayType::OTHER,
            ],
            'long-date' => [
                'new_year',
                '2024-01-01xyz',
                HolidayType::OTHER,
            ],
            'invalid-date' => [
                'new_year',
                '2024-x1-01',
                HolidayType::OTHER,
            ],
            'type-less-than-zero' => [
                'new_year',
                '2024-01-01',
                -1,
            ],
            'type-too-big' => [
                'new_year',
                '2024-01-01',
                5682052057,
            ],
        ];
    }

    private function thenInvalidArgumentExceptionShouldBeThrown(): void
    {
        $this->expectException(InvalidArgumentException::class);
    }

    #[DataProvider('getDateTimeData')]
    #[Test]
    public function itBuildsCorrectlyFromCreate(string $name, string $date, int $type): void
    {
        $this->whenHolidayIsCreatedFromCreate($name, $date, $type);
        $this->thenThisNameShouldBeSet($name);
        $this->thenThisSimpleDateShouldBeSet($date);
        $this->thenThisTypeShouldBeSet($type);
    }

    private function whenHolidayIsCreatedFromCreate(string $name, string $date, int $type): void
    {
        $this->holiday = Holiday::create($name, $date, $type);
    }

    #[DataProvider('getDateTimeData')]
    #[Test]
    public function itBuildsCorrectlyFromCreateFromDateTime(string $name, string $date, int $type): void
    {
        $this->whenHolidayIsCreatedFromCreateFromDateTime($name, $date, $type);
        $this->thenThisNameShouldBeSet($name);
        $this->thenThisSimpleDateShouldBeSet($date);
        $this->thenThisTypeShouldBeSet($type);
    }

    public static function getDateTimeData(): array
    {
        return [
            ['foo', '1917-01-01', HolidayType::DAY_OFF],
            ['bar', '1970-01-01', HolidayType::OTHER],
            ['baz', '2000-02-29', HolidayType::BANK | HolidayType::NO_SCHOOL],
        ];
    }

    private function whenHolidayIsCreatedFromCreateFromDateTime(string $name, string $date, int $type): void
    {
        $this->holiday = Holiday::createFromDateTime($name, new DateTime($date), $type);
    }

    #[DataProvider('getDetailedDateTimeData')]
    #[Test]
    public function itShouldReturnDateTime(string $date, string $timezone, DateTimeImmutable $expectedResult): void
    {
        $this->givenHolidayWithDate($date);
        $this->whenGetDateIsCalled($timezone);
        $this->thenThisDateShouldBeReturned($expectedResult);
    }

    public static function getDetailedDateTimeData(): array
    {
        return [
            ['1917-01-01', 'Europe/Berlin', new DateTimeImmutable('1917-01-01T00:00:00+0100')],
            ['1970-01-01', 'America/Argentina/Cordoba', new DateTimeImmutable('1970-01-01T00:00:00-0300')],
            ['2020-10-31', 'Asia/Manila', new DateTimeImmutable('2020-10-31T00:00:00+0800')],
        ];
    }

    private function givenHolidayWithDate(string $date): void
    {
        $this->holiday = Holiday::create('name', $date);
    }

    private function whenGetDateIsCalled(string $timezone): void
    {
        $this->actualResult = $this->holiday->getDate(new DateTimeZone($timezone));
    }

    private function thenThisDateShouldBeReturned(DateTimeImmutable $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    #[DataProvider('getTypeData')]
    #[Test]
    public function itShouldReturnIfItHasType(int $typeToSet, int $checkedType, bool $expectedResult): void
    {
        $this->givenHolidayWithType($typeToSet);
        $this->whenHasTypeIsCalled($checkedType);
        $this->thenTheExpectedResultShouldBeReturned($expectedResult);
    }

    public static function getTypeData(): array
    {
        return [
            [HolidayType::NO_SCHOOL, HolidayType::NO_SCHOOL, true],
            [HolidayType::OTHER, HolidayType::NO_SCHOOL, false],
            [HolidayType::NO_SCHOOL, HolidayType::OTHER, false],
            [HolidayType::OTHER, HolidayType::OTHER, true],
            [HolidayType::NO_SCHOOL | HolidayType::BANK, HolidayType::NO_SCHOOL, true],
            [HolidayType::NO_SCHOOL | HolidayType::BANK, HolidayType::NO_SCHOOL | HolidayType::BANK, true],
            [HolidayType::NO_SCHOOL | HolidayType::BANK | HolidayType::DAY_OFF, HolidayType::NO_SCHOOL | HolidayType::BANK, true],
        ];
    }

    private function givenHolidayWithType(int $type): void
    {
        $this->holiday = Holiday::create('name', '2020-01-01', $type);
    }

    private function whenHasTypeIsCalled(int $type): void
    {
        $this->actualResult = $this->holiday->hasType($type);
    }

    private function thenTheExpectedResultShouldBeReturned(bool $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    #[Test]
    public function itShouldFormatSelf(): void
    {
        $this->givenHoliday('name', '2019-06-30', HolidayType::DAY_OFF);
        $this->whenFormatIsCalledWithSomeFormatter();
        $this->thenTheExpectedStringShouldBeReturned('name|2019-06-30|2');
    }

    private function givenHoliday(string $name, string $date, int $type): void
    {
        $this->holiday = Holiday::create($name, $date, $type);
    }

    private function whenFormatIsCalledWithSomeFormatter(): void
    {
        $this->actualResult = $this->holiday->format(new FormatterStub());
    }

    private function thenTheExpectedStringShouldBeReturned(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }
}
