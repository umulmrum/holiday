<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Constant\Weekday;

class Mondays extends Weekdays
{
    public function __construct()
    {
        parent::__construct(Weekday::MONDAY);
    }
}
