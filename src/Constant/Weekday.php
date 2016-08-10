<?php


namespace umulmrum\Holiday\Constant;


class Weekday
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    public static $NAME = [
        self::SUNDAY => HolidayName::SUNDAY,
        self::MONDAY => HolidayName::MONDAY,
        self::TUESDAY => HolidayName::TUESDAY,
        self::WEDNESDAY => HolidayName::WEDNESDAY,
        self::THURSDAY => HolidayName::THURSDAY,
        self::FRIDAY => HolidayName::FRIDAY,
        self::SATURDAY => HolidayName::SATURDAY,
    ];
}