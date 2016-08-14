<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
