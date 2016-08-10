<?php

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Constant\Weekday;

class Thursdays extends Weekdays
{
    const ID = 'THURSDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::THURSDAY);
    }
}
