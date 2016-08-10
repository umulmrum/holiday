<?php


namespace umulmrum\Holiday\Provider\Weekday;


use umulmrum\Holiday\Constant\Weekday;

class Wednesdays extends Weekdays
{
    const ID = 'WEDNESDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::WEDNESDAY);
    }
}