<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Constant;

/**
 * @codeCoverageIgnore
 */
final class Weekday
{
    /** @var int */
    public const SUNDAY = 0;
    /** @var int */
    public const MONDAY = 1;
    /** @var int */
    public const TUESDAY = 2;
    /** @var int */
    public const WEDNESDAY = 3;
    /** @var int */
    public const THURSDAY = 4;
    /** @var int */
    public const FRIDAY = 5;
    /** @var int */
    public const SATURDAY = 6;

    /** @var string[] */
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
