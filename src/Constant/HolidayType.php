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

use Umulmrum\Holiday\Translator\TranslatorInterface;

use function count;

/**
 * HolidayType defines constants for different types of holidays. These can be combined to describe a holiday that
 * fulfills multiple criteria (e.g. for holidays that are both religious and days off).
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
     * DAY_OFF, the GOVERNMENT_AGENCIES_CLOSED type is not applied separately.
     */
    public const GOVERNMENT_AGENCIES_CLOSED = 64;

    /**
     * On a holiday of type HALF_DAY_OFF, employees usually only work half their normal working hours.
     */
    public const HALF_DAY_OFF = 128;

    /**
     * On a holiday of type BANK, banks are usually closed. Other regulations or traditions depend on the country or
     * region, and on the holiday itself.
     */
    public const BANK = 256;

    /**
     * A holidy of type COMPENSATORY is added to a list if for a provider there are rules that holidays that fall on a
     * Saturday or Sunday are "replaced" with a weekday. Compensatory holidays are always added in addition to the
     * original holiday.
     */
    public const COMPENSATORY = 512;

    /**
     * On a holiday of type SHOPS_CLOSED, retail stores and/or other businesses must stay closed. If the holiday is also a
     * DAY_OFF, the SHOPS_CLOSED type is not applied separately.
     */
    public const SHOPS_CLOSED = 1024;

    public const RESERVED3 = 2048;

    public const RESERVED4 = 4096;

    public const RESERVED5 = 8192;

    public const RESERVED6 = 16384;

    public const ALL =
        self::OTHER
        | self::OFFICIAL
        | self::DAY_OFF
        | self::RELIGIOUS
        | self::TRADITIONAL
        | self::PARTIAL_ONLY
        | self::NO_SCHOOL
        | self::GOVERNMENT_AGENCIES_CLOSED
        | self::HALF_DAY_OFF
        | self::BANK
        | self::COMPENSATORY
        | self::SHOPS_CLOSED;

    /** @var string[] */
    public static array $NAME = [
        self::OTHER => 'other',
        self::OFFICIAL => 'official',
        self::DAY_OFF => 'day_off',
        self::RELIGIOUS => 'religious',
        self::TRADITIONAL => 'traditional',
        self::PARTIAL_ONLY => 'partial_only',
        self::NO_SCHOOL => 'no_school',
        self::HALF_DAY_OFF => 'half_day_off',
        self::GOVERNMENT_AGENCIES_CLOSED => 'government_agencies_closed',
        self::BANK => 'bank',
        self::COMPENSATORY => 'compensatory',
        self::SHOPS_CLOSED => 'shops_closed',
    ];

    /**
     * @return string[]
     */
    public static function getTypeNames(TranslatorInterface $translator, int $holidayType): array
    {
        $typeList = self::getTypeList($holidayType);
        $translatedList = [];
        foreach ($typeList as $type) {
            $translatedList[] = $translator->translate(self::$NAME[$type]);
        }

        return $translatedList;
    }

    /**
     * @return int[]
     */
    public static function getTypeList(int $type): array
    {
        $typeList = [];

        $counter = 1;
        while (0 !== $type) {
            if (0 !== ($type & $counter)) {
                $typeList[] = $counter;
            }
            $type &= ~$counter;
            $counter <<= 1;
        }
        if (0 === count($typeList)) {
            $typeList[] = self::OTHER;
        }

        return $typeList;
    }
}
