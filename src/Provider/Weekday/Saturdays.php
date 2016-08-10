<?php

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Constant\Weekday;

class Saturdays extends Weekdays
{
    const ID = 'SATURDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::SATURDAY);
    }
}
