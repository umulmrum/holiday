<?php


namespace umulmrum\Holiday\Helper;


use DateTime;
use DateTimeZone;

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