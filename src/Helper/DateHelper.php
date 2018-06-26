<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Helper;

use DateTime;
use DateTimeZone;

/**
 * DateHelper is a simple encapsulation for getting the current date.
 * Its purpose is only to be able to mock the date in unit tests.
 *
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
