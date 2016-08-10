<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;

class LowerSaxony extends Germany
{
    const ID = 'DE-NI';

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
