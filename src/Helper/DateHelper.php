<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Helper;

use DateTime;
use DateTimeZone;

/**
 * @codeCoverageIgnore
 */
class DateHelper
{
    /**
     * @param DateTimeZone $timeZone
     *
     * @return DateTime
     */
    public function getCurrentDate(DateTimeZone $timeZone)
    {
        return new DateTime('now', $timeZone);
    }
}
