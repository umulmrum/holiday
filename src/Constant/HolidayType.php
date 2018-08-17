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
 * HolidayType defines constants for different types of holidays. These can be combined to describe a holiday that
 * fulfills multiple criteria (e.g. for holidays that are both religious and days off).
 *
 * @codeCoverageIgnore
 */
class HolidayType
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
     * A holiday of type PARTIAL_AREA_ONLY is not celebrated in the whole region.
     */
    public const PARTIAL_AREA_ONLY = 16;

    public static $NAME = [
        self::OTHER => 'other',
        self::OFFICIAL => 'official',
        self::DAY_OFF => 'day_off',
        self::RELIGIOUS => 'religious',
        self::TRADITIONAL => 'traditional',
        self::PARTIAL_AREA_ONLY => 'partial_area_only',
    ];
}
