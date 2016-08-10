<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;

class SchleswigHolstein extends Germany
{
    const ID = 'DE-SH';

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return self::ID;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null)
    {
        return parent::calculateHolidaysForYear($year, $timezone);
    }
}
