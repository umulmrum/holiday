<?php


namespace umulmrum\Holiday\Provider\Weekday;


use umulmrum\Holiday\Constant\Weekday;

class Fridays extends Weekdays
{
    const ID = 'FRIDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::FRIDAY);
    }
}