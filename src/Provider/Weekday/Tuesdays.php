<?php


namespace umulmrum\Holiday\Provider\Weekday;


use umulmrum\Holiday\Constant\Weekday;

class Tuesdays extends Weekdays
{
    const ID = 'TUESDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::TUESDAY);
    }
}