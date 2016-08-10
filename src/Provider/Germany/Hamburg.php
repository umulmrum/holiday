<?php

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;

class Hamburg extends Germany
{
    const ID = 'DE-HH';

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
