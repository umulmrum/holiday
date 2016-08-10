<?php


namespace umulmrum\Holiday\Provider\Weekday;


use umulmrum\Holiday\Constant\Weekday;

class Mondays extends Weekdays
{
    const ID = 'MONDAYS';

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    public function __construct()
    {
        parent::__construct(Weekday::MONDAY);
    }
}