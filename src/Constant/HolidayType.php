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
 * HolidayType defines constants for different types of holidays. These can be combined to describe a holiday that
 * fulfills multiple criteria (e.g. for holidays that are both religious and days off).
 *
 * @codeCoverageIgnore
 */
final class HolidayType
{
    /**
     * This is a holiday that is not further specified - one might call it a dummy value.
     */
    public const OTHER = 0;
    /**
     * A holiday of type OFFICIAL is guaranteed by law. Note that this does not automatically mean
     * that the holiday is also a day off - combine with DAY_OFF to express that the holiday is
     * indeed no working day.
     */
    public const OFFICIAL = 1;
    /**
     * On a holiday of type DAY_OFF, it is usually not allowed to work (exceptions may apply).
     * This can be both a "real" holiday and a weekday on which working is not allowed (normally this is Sunday).
     */
    public const DAY_OFF = 2;
    /**
     * A holiday of type RELIGIOUS is a holiday of one or more religious organizations or beliefs.
     */
    public const RELIGIOUS = 4;
    /**
     * A holiday of type TRADITIONAL has its origins in the past, but not in religion.
     */
    public const TRADITIONAL = 8;
    /**
     * A holiday of type PARTIAL_ONLY is not celebrated in the whole region or not a holiday for all people. Some
     * holidays are e.g. limited to members of certain churches.
     */
    public const PARTIAL_ONLY = 16;
    /**
     * On a holiday of type NO_SCHOOL pupils do not attend school. If the holiday is also a DAY_OFF, the
     * NO_SCHOOL type is not applied separately.
     */
    public const NO_SCHOOL = 32;
    /**
     * On a holiday of type GOVERNMENT_AGENCIES_CLOSED, well, government agencies are closed. If the holiday is also a
     * DAY_OFF, the NO_SCHOOL type is not applied separately.
     */
    public const GOVERNMENT_AGENCIES_CLOSED = 64;
    /**
     * On a holiday of type HALF_DAY_OFF, employees usually only work half their normal working hours.
     */
    public const HALF_DAY_OFF = 128;

    public const BANK = 256;
    /**
     * A holidy of type COMPENSATORY is added to a list if for a provider there are rules that holidays that fall on a
     * Saturday or Sunday are "replaced" with a weekday. Compensatory holidays are always added in addition to the
     * original holiday.
     */
    public const COMPENSATORY = 512;

    public const RESERVED2 = 1024;

    public const RESERVED3 = 2048;

    public const RESERVED4 = 4096;

    public const RESERVED5 = 8192;

    public const RESERVED6 = 16384;

    /** @var string[] */
    public static $NAME = [
        self::OTHER => 'other',
        self::OFFICIAL => 'official',
        self::DAY_OFF => 'day_off',
        self::RELIGIOUS => 'religious',
        self::TRADITIONAL => 'traditional',
        self::PARTIAL_ONLY => 'partial_only',
        self::NO_SCHOOL => 'no_school',
        self::GOVERNMENT_AGENCIES_CLOSED => 'government_agencies_closed',
        self::BANK => 'bank',
        self::COMPENSATORY => 'compensatory',
    ];
}
