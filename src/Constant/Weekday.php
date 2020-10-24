<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Constant;

/**
 * @codeCoverageIgnore
 */
final class Weekday
{
    public const SUNDAY = 0;
    public const MONDAY = 1;
    public const TUESDAY = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY = 4;
    public const FRIDAY = 5;
    public const SATURDAY = 6;

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
