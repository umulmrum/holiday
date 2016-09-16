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

use DateInterval;
use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Model\Holiday;

trait WeekdayTrait
{
    /**
     * @param int          $year
     * @param int          $weekday
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday[]
     */
    private function getWeekdays($year, $weekday, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $start = new DateTime(sprintf('%s-01-01', $year), $timezone);
        $end = new DateTime(sprintf('%s-01-01', $year + 1), $timezone);
        $day = new DateTime();
        $weekdayName = Weekday::$NAME[$weekday];
        $day->setTimestamp(strtotime($weekdayName, $start->getTimestamp()));
        $holidays = [];

        while ($day->getTimestamp() < $endDate = $end->getTimestamp()) {
            $holidays[] = new Holiday($weekdayName, clone $day, HolidayType::DAY_OFF | $additionalType);
            $day->add(new DateInterval('P7D'));
        }

        return $holidays;
    }
}
