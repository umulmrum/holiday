<?php

namespace umulmrum\Holiday\Constant;

class HolidayType
{
    /**
     * This is a holiday that is not further specified - one might call it a dummy value.
     */
    const OTHER = 0;
    /**
     * A holiday of type OFFICIAL is guaranteed by law.
     */
    const OFFICIAL = 1;
    /**
     * On a holiday of type DAY_OFF, it is usually not allowed to work (exceptions may apply).
     */
    const DAY_OFF = 2;
    /**
     * A holiday of type RELIGIOUS is a holiday of one or more religious organizations or beliefs.
     */
    const RELIGIOUS = 4;
    /**
     * A holiday of type TRADITIONAL has its origins in the past, but not in religion.
     */
    const TRADITIONAL = 8;
    /**
     * A holiday of type NO_WORK_DAY is a weekday on which it is usually not allowed to work. In western countries
     * this is usually on sunday.
     */
    const NO_WORK_DAY = 16;
    /**
     * A holiday of type PARTIAL_AREA_ONLY is not celebrated in the whole region.
     */
    const PARTIAL_AREA_ONLY = 32;
}
