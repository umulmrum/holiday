<?php


namespace umulmrum\Holiday\Provider\Weekday;


use umulmrum\Holiday\Constant\Weekday;

class Sundays extends Weekdays
{
    const ID = 'SUNDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::SUNDAY);
    }
}